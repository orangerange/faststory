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
    }

    public function characterSpeak() {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;
        $this->request->allowMethod(['ajax']);

        $phraseNo = $this->request->getData('phrase_no');
        $characterId = $this->request->getData('character_id');
        $sentence = $this->request->getData('sentence');
        $sentenceTranslate = $this->request->getData('sentence_translate');
        $character = $this->Characters->find()->where(['Characters.id' => $characterId])->contain(['Ranks'])->first();
        $objectUsage = $this->request->getData('object_usage');
        $speak = $this->ObjectProducts->findSpeak($character, $objectUsage);
        $html = false;
        $css = false;
        $badgeLeftHtml = false;
        $badgeRightHtml = false;
        $bodyWidth = 0;
        $faceRelLeft = 0;
        if (isset($speak['face']->id) || isset($speak['body']->id) || isset($speak['right_arm']->id) || isset($speak['speech']->id)) {
            // html
            $view = $this->createView();
            $view->set(['rightArm'=>$speak['right_arm'], 'face'=>$speak['face'], 'body'=>$speak['body'], 'speech'=>$speak['speech'], 'sentence'=>$sentence, 'sentence_translate'=>$sentenceTranslate, 'character'=>$character, 'phraseNo'=>$phraseNo]);
            $html = $view->render('AdminAjax/Chapters/character_speak_html');
            // css
            $rightArmCss = '';
            if (isset($speak['right_arm']->id)) {
                $rightArmId = $speak['right_arm']->id;
                $rightArmWidth = $speak['right_arm']->object_template->width;
                $rightArmHeight = $speak['right_arm']->object_template->height;
                $rightArmCss = $speak['right_arm']->css;
                $rightArmCss = AppUtility::addPreClassToCss($rightArmCss, '.right_arm.object_' . $rightArmId);
                $rightArmCss = "/*.right_arm.object_{$rightArmId}_start*/" . $this->_makeBaseCss('.right_arm.object_' . $rightArmId, $rightArmWidth, $rightArmHeight, 'right_arm', $faceRelLeft, $objectUsage) . ' ' . $rightArmCss . "/*.right_arm.object_{$rightArmId}_end*/";
            }
            $bodyCss = '';
            if (isset($speak['body']->id)) {
                $bodyId = $speak['body']->id;
                if ($objectUsage == Configure::read('object_usage_key.story_show')) {
                    $bodyWidth = round($speak['body']->object_template->width * 1.8);
                    $bodyHeight = round($speak['body']->object_template->height * 1.8);
                } else {
                    $bodyWidth = $speak['body']->object_template->width;
                    $bodyHeight = $speak['body']->object_template->height;
                }

                $bodyCss = $speak['body']->css;

                if ($speak['badge_left']) {
                    $badgeLeftCss = AppUtility::addPreClassToCss($speak['badge_left']->css, '.rank_badge_left');
                    $bodyCss .= $badgeLeftCss;
                    $badgeLeftHtml = $speak['badge_left']->html;
                }
                if ($speak['badge_right']) {
                    $badgeRightCss = AppUtility::addPreClassToCss($speak['badge_right']->css, '.rank_badge_right');
                    $bodyCss .= $badgeRightCss;
                    $badgeRightHtml = $speak['badge_right']->html;
                    // 階級章(右)が階級章(左)の鏡映しとなる場合
                } elseif ($speak['badge_left']) {
                    // 鑑写し指定
                    $badgeRightCss = '.rank_badge_right{transform: scale(-1, 1)}';
                    $badgeRightCss .= AppUtility::addPreClassToCss($speak['badge_left']->css, '.rank_badge_right');
                    $bodyCss .= $badgeRightCss;
                    $badgeRightHtml = $speak['badge_left']->html;
                }
                $bodyCss = AppUtility::addPreClassToCss($bodyCss, '.body.object_' . $bodyId);
                $bodyCss = "/*.body.object_{$bodyId}_start*/" . $this->_makeBaseCss('.body.object_' . $bodyId, $bodyWidth, $bodyHeight, 'body', $faceRelLeft, $objectUsage) . ' ' . $bodyCss . "/*.body.object_{$bodyId}_end*/";
            }
            $faceCss = '';
            if (isset($speak['face']->id)) {
                $faceId = $speak['face']->id;
                if ($objectUsage == Configure::read('object_usage_key.story_show')) {
                    $faceWidth = round($speak['face']->object_template->width * 1.8);
                    $faceHeight = round($speak['face']->object_template->height * 1.8);
                } else {
                    $faceWidth = $speak['face']->object_template->width;
                    $faceHeight = $speak['face']->object_template->height;
                }

                $faceRelLeft = ($bodyWidth - $faceWidth) / 2;

                $faceCss = $speak['face']->css;
                $faceCss = AppUtility::addPreClassToCss($faceCss, '.face.object_' . $faceId);
                $faceCss = "/*.face.object_{$faceId}_start*/" . $this->_makeBaseCss('.face.object_' . $faceId, $faceWidth, $faceHeight, 'face', $faceRelLeft, $objectUsage) . ' ' . $faceCss . "/*.face.object_{$faceId}_end*/";
            }
            $speechCss = '';
            if (isset($speak['speech']->id)) {
                $speechId = $speak['speech']->id;
                $speechWidth = $speak['speech']->object_template->width;
                $speechHeight = $speak['speech']->object_template->height;
                $speechCss = $speak['speech']->css;
                $speechCss = AppUtility::addPreClassToCss($speechCss, '.speech.object_' . $speechId);
                $speechCss = "/*.speech.object_{$speechId}_start*/" . $this->_makeBaseCss('.speech.object_' . $speechId, $speechWidth, $speechHeight, 'speech', $faceRelLeft, $objectUsage) . ' ' . $speechCss . "/*.speech.object_{$speechId}_end*/";
            }
            $objectUsageArr = array_flip(Configure::read('object_usage_key'));
            $objectUsageName = $objectUsageArr[$objectUsage];
            $css = '.character_speak_' . $phraseNo . '{' . Configure::read("object_layout.{$objectUsageName}.character_speak") .'}';
            $css = "/*.character_speak_{$phraseNo}_start*/" . $css . $rightArmCss . $faceCss . $bodyCss . "/*.character_speak_{$phraseNo}_end*/" . $speechCss;
        }
        $result = ['html' => $html, 'css' => $css, 'badge_left_html' => $badgeLeftHtml, 'badge_right_html' => $badgeRightHtml];

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

    private function _makeBaseCss($baseClass, $width, $height, $speakType, $faceRelLeft, $objectUsage) {
        $this->autoRender = false;
        $baseCss = $baseClass . '{ width:' . $width . '%;' . ' height:' . $height . '%; position:absolute;';
        $objectUsageArr = array_flip(Configure::read('object_usage_key'));
        $objectUsageName = $objectUsageArr[$objectUsage];
        switch ($speakType) {
            case 'face':
                $baseCss .= Configure::read("object_layout.{$objectUsageName}.face") . 'left:' . $faceRelLeft . '%;';
                break;
            default:
                $baseCss .= Configure::read("object_layout.{$objectUsageName}.{$speakType}");
                break;
        }
        $baseCss .= '}';
        return $baseCss;
    }
}
