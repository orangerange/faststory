<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\AdminAjax;

use App\Controller\Admin\AdminAppController;
use App\Utils\AppUtility;
use Cake\Http\Exception\NotFoundException;
use Cake\Core\Configure;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChaptersController extends AdminAppController
{

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('ObjectProducts');
		$this->loadModel('Characters');
		$this->loadModel('ActionLayouts');
		$this->loadModel('CharacterSpeakLayouts');
    }

    public function characterSpeak() {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $this->request->allowMethod(['ajax']);

        $phraseNo = $this->request->getData('phrase_no');
        $characterId = $this->request->getData('character_id');
        $character = $this->Characters->find()->where(['Characters.id' => $characterId])->contain(['Ranks'])->first();
        $objectUsage = $this->request->getData('object_usage');

        $actionLayouts = $this->ActionLayouts->findSpeak($characterId, $objectUsage);

        $htmlSum = '';
        $cssSum = '';
        $characterHtmlSum = '';
        $characterCssSum = '';
        $badgeLeftHtml = null;
        $badgeRightHtml = null;
        $speechActionLayout = null;
        $noCharacterActionLayouts = [];
        $objectClassNames = [];

        foreach($actionLayouts as $actionLayout) {
            if (!empty($actionLayout['no_character'])) {
                if (is_null($actionLayout['character_id']) || $actionLayout['character_id'] == '') {
                    if (!isset($noCharacterActionLayouts[$actionLayout['object_product']['template_id']])) {
                        $noCharacterActionLayouts[$actionLayout['object_product']['template_id']] = $actionLayout;
                    }
                } else {
                    $noCharacterActionLayouts[$actionLayout['object_product']['template_id']] = $actionLayout;
                }
            } else {
                $objectClassNames[$actionLayout['object_product']['id']] = $actionLayout['object_product']['object_template']['class_name'];
                $this->_addHtmlAndCss($characterHtmlSum, $characterCssSum, $htmlSum, $cssSum, $badgeLeftHtml, $badgeRightHtml,  $actionLayout, $character, $phraseNo);
            }
        }

        // キャラクター関係なく共通(※キャラクターIDの定義ある場合のみ限定)部分のHTML・CSSを生成
        foreach ($noCharacterActionLayouts as $templateId => $actionLayout) {
            $objectClassNames[$actionLayout['object_product']['id']] = $actionLayout['object_product']['object_template']['class_name'];
            $this->_addHtmlAndCss($characterHtmlSum, $characterCssSum, $htmlSum, $cssSum, $badgeLeftHtml, $badgeRightHtml,  $actionLayout, $character, $phraseNo);
        }

        // html
        $view = $this->createView();
        $view->set(['characterHtmlSum' => $characterHtmlSum, 'htmlSum' => $htmlSum, 'phraseNo' => $phraseNo, 'characterId' => $characterId]);
        $html = $view->render('AdminAjax/Chapters/character_speak_html');

        if ($characterCssSum != '') {
            $characterSpeakLayout = null;
            $characterSpeakLayouts = $this->CharacterSpeakLayouts->findLayout($actionLayout['action_id']);
            foreach ($characterSpeakLayouts as $layout) {
                if (is_null($layout['character_id']) || $layout['character_id'] == '') {
                    if (!isset($characterSpeakLayout)) {
                        $characterSpeakLayout = $layout;
                    }
                } else {
                    if ($layout['character_id'] == $characterId) {
                        $characterSpeakLayout = $layout;
                    }
                }
            }
            $characterCssSumHead = '.character_speak_' . $phraseNo . '_' . $characterId . '{ width:100%; height:100%; position:absolute; ';
            if (isset($characterSpeakLayout['left_perc'])) {
                $characterCssSumHead .= 'left:' . $characterSpeakLayout['left_perc'] . '%; ';
            } elseif($characterSpeakLayout['right_perc']) {
                $characterCssSumHead .= 'right:' . $characterSpeakLayout['right_perc'] . '%; ';
            }
//            $characterCssSumHead .= isset($characterSpeakLayout['left_perc']) && $characterSpeakLayout['left_perc'] != '' ? 'left:' . $characterSpeakLayout['left_perc'] . '%; ' : 'right:' . $characterSpeakLayout['right_perc'] . '%; ';
            $characterCssSumHead .= '} ';
            $characterCssSum = $characterCssSumHead . $characterCssSum;
        }

        $css = $characterCssSum != '' ? "/*.character_speak_{$phraseNo}_{$characterId}_start*/" . $characterCssSum . "/*.character_speak_{$phraseNo}_end*/"  . $cssSum: $cssSum;

        $result = ['html' => $html, 'css' => $css, 'badge_left_html' => $badgeLeftHtml, 'badge_right_html' => $badgeRightHtml, 'object_class_names' => $objectClassNames];

        $this->response->getBody()->write(json_encode($result));
    }

    public function objectLayout() {
        $this->viewBuilder()->setLayout(false);
        // Ajax からのリクエストか、否かを確認
        if ($this->request->is("ajax")) {
            $css = $this->request->getData('css');
            $i = $this->request->getData('phrase_no');
            $Utils = new AppUtility();
            $layouts = $Utils->createObjectLayoutByCss($css);
            $this->set(compact('layouts', 'i'));
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

//    private function _makeBaseCss($baseClass, $width, $height, $speakType, $faceRelLeft, $objectUsage) {
//        $this->autoRender = false;
//        $baseCss = $baseClass . '{ width:' . $width . '%;' . ' height:' . $height . '%; position:absolute;';
//        $objectUsageArr = array_flip(Configure::read('object_usage_key'));
//        $objectUsageName = $objectUsageArr[$objectUsage];
//        switch ($speakType) {
//            case 'face':
//                $baseCss .= Configure::read("object_layout.{$objectUsageName}.face") . 'left:' . $faceRelLeft . '%;';
//                break;
//            default:
//                $baseCss .= Configure::read("object_layout.{$objectUsageName}.{$speakType}");
//                break;
//        }
//        $baseCss .= '}';
//        return $baseCss;
//    }

    private function _makeObjectHtml($objectClassName, $objectId, $contentHtml) {
        $objectHtml = '<div class="' . $objectClassName . ' ' . 'object_' . $objectId . '">';
        $objectHtml .= $contentHtml;
        $objectHtml .= '</div>';

        return $objectHtml;
    }

    private function _makeBaseCss($baseClass, $width, $height, $left, $top, $right, $bottom, $rotate, $backgroundImg) {
        $this->autoRender = false;
        $baseCss = $baseClass . '{ ' . 'width:' . $width . '%; ' . ' height:' . $height . '%; position:absolute;';
        $baseCss .= '--object_width:calc(var(--phrase_object_width) * ' .  $width / 100 . '); --object_height:calc(var(--phrase_object_height) * ' . $height / 100 . ');';
        if (isset($backgroundImg))
        $baseCss .= 'background-image: url(' . $backgroundImg .'); background-size: cover;';
        if (isset($left) && $left != '') {
            $baseCss .= 'left:' . $left . '%; ';
        } elseif(isset($right) && $right != '') {
            $baseCss .= 'right:' . $right . '%; ';
        }

        if (isset($top) && $top != '') {
            $baseCss .= 'top:' . $top . '%; ';
        } elseif(isset($bottom) && $bottom != '') {
            $baseCss .= 'bottom:' . $bottom . '%; ';
        }
        if (isset($rotate) && $rotate != '') {
            $baseCss .= 'transform:rotate(' . $rotate . 'deg); ';
        }

        $baseCss .= '}';
        return $baseCss;
    }

    private function _addHtmlAndCss(&$characterHtmlSum, &$characterCssSum, &$htmlSum, &$cssSum, &$badgeLeftHtml, &$badgeRightHtml, $actionLayout, $character, $phraseNo) {
        $left = $actionLayout['left_perc'];
        $top = $actionLayout['top_perc'];
        $right = $actionLayout['right_perc'];
        $bottom = $actionLayout['bottom_perc'];
        $rotate = $actionLayout['rotate'];
        $magnification = $actionLayout['magnification'];
        if (!isset($magnification) || $magnification =='') {
            $magnification == 1;
        }
        $width = (float)$magnification * (float)$actionLayout['object_product']['object_template']['width'];
        $height = (float)$magnification * (float)$actionLayout['object_product']['object_template']['height'];
        $objectId = $actionLayout['object_product']['id'];
        $objectClassName = $actionLayout['object_product']['object_template']['class_name'];

        //html生成
        $html = $this->_makeObjectHtml($objectClassName, $objectId, $actionLayout['object_product']['html']);
        if (!empty($actionLayout['is_character'])) {
            $characterHtmlSum .= $html;
        } else {
            $htmlSum .= $html;
        }
        //css生成
        $css = $actionLayout['object_product']['css'];
        if ($actionLayout['object_product']['template_id'] == OBJECT_TEMPLATE_BODY  || $actionLayout['object_product']['template_id'] == OBJECT_TEMPLATE_NOTEBOOK) {
            //階級章調整
            $rankBadges = $this->ObjectProducts->findRankBadges($character);
            if ($rankBadges['badge_left']) {
                $badgeLeftCss = AppUtility::addPreClassToCss($rankBadges['badge_left']->css, '.rank_badge_left');
                $css .= $badgeLeftCss;
                $badgeLeftHtml = $rankBadges['badge_left']->html;
            }
            if ($rankBadges['badge_right']) {
                $badgeRightCss = AppUtility::addPreClassToCss($rankBadges['badge_right']->css, '.rank_badge_right');
                $css .= $badgeRightCss;
                $badgeRightHtml = $rankBadges['badge_right']->html;
                // 階級章(右)が階級章(左)の鏡映しとなる場合
            } elseif ($rankBadges['badge_left']) {
                // 鑑写し指定
                $badgeRightCss = '.rank_badge_right{transform: scale(-1, 1)}';
                $badgeRightCss .= AppUtility::addPreClassToCss($rankBadges['badge_left']->css, '.rank_badge_right');
                $css .= $badgeRightCss;
                $badgeRightHtml = $rankBadges['badge_left']->html;
            }
        }
        $backgroundImg = null;
        if (!empty($actionLayout['object_product']['picture_content'])) {
            $backgroundImg = '/objects/picture/' . $objectId;
        }
        $css = AppUtility::addPreClassToCss($css, '.' . $objectClassName . '.object_' . $objectId);
        $css = "/*." . $objectClassName . ".object_{$objectId}_start*/" . $this->_makeBaseCss('.' . $objectClassName . '.object_' . $objectId, $width, $height, $left, $top, $right, $bottom, $rotate, $backgroundImg) . ' ' . $css . "/*." . $objectClassName .  ".object_{$objectId}_end*/";
        if (!empty($actionLayout['is_character'])) {
            $characterCssSum .= $css;
        } else {
            $cssSum .= $css;
        }
    }
}
