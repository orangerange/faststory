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

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use App\Utils\AppUtility;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChaptersController extends AppController
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
        $character = $this->Characters->find()->where(['Characters.id' => $characterId])->contain(['Ranks'])->first();;
        $speak = $this->ObjectProducts->findSpeak($character);
        $html = false;
        $css = false;
        if (isset($speak['face']->id) && isset($speak['body']->id)) {
            // html
            $view = $this->createView();
            $view->set(['face'=>$speak['face'], 'body'=>$speak['body'], 'speech'=>$speak['speech'], 'sentence'=>$sentence, 'sentence_translate'=>$sentenceTranslate, 'character'=>$character, 'phraseNo'=>$phraseNo]);
            $html = $view->render('AdminAjax/Chapters/character_speak_html');
            // css
            $faceId = $speak['face']->id;
            $faceWidth = $speak['face']->object_template->width;
            $faceHeight = $speak['face']->object_template->height;
            $bodyId = $speak['body']->id;
            $bodyWidth = $speak['body']->object_template->width;
            $bodyHeight = $speak['body']->object_template->height;
            $speechId = $speak['speech']->id;
            $speechWidth = $speak['speech']->object_template->width;
            $speechHeight = $speak['speech']->object_template->height;
            $faceRelLeft = ($bodyWidth - $faceWidth)/2;

            $faceCss = $speak['face']->css;
            $faceCss = AppUtility::addPreClassToCss($faceCss, '.face.object_' . $faceId);
            $faceCss = "/*.face.object_{$faceId}_start*/". $this->_makeBaseCss('.face.object_' . $faceId, $faceWidth, $faceHeight, 'face', $faceRelLeft) . ' ' . $faceCss . "/*.face.object_{$faceId}_end*/";

            $bodyCss = $speak['body']->css;
            $badgeLeftHtml = false;
            $badgeRightHtml = false;
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
            $bodyCss = "/*.body.object_{$bodyId}_start*/". $this->_makeBaseCss('.body.object_' . $bodyId, $bodyWidth, $bodyHeight, 'body', $faceRelLeft) . ' ' . $bodyCss . "/*.body.object_{$bodyId}_end*/";

            $speechCss = $speak['speech']->css;
            $speechCss = AppUtility::addPreClassToCss($speechCss, '.speech.object_' . $speechId);
            $speechCss = "/*.speech.object_{$speechId}_start*/". $this->_makeBaseCss('.speech.object_' . $speechId, $speechWidth, $speechHeight, 'speech', $faceRelLeft) . ' ' . $speechCss . "/*.speech.object_{$speechId}_end*/";

            $css ='.character_speak_' . $phraseNo . '{left:10%; width:100%; height:100%; position:absolute;}';
            $css = "/*.character_speak_{$phraseNo}_start*/" . $css . $faceCss . $bodyCss . "/*.character_speak_{$phraseNo}_end*/"  . $speechCss;
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
            $layouts = $this->Chapters->findObjectLayoutByCss($css);
            $this->set(compact('layouts', 'i'));
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    private function _makeBaseCss($baseClass, $width, $height, $speakType, $faceRelLeft) {
        $this->autoRender = false;
        $baseCss = $baseClass . '{ width:' . $width . '%;' . ' height:' . $height . '%; position:absolute;';
        switch ($speakType) {
            case 'face':
                $baseCss .= ' top:12%; left:' . $faceRelLeft . '%;';
                break;
            case 'body':
                $baseCss .= ' bottom:0%; left:0%;';
                break;
            case 'speech':
                $baseCss .= ' top:10%; right:5%;';
                break;
            default:
                break;
        }
        $baseCss .= '}';
        return $baseCss;
    }

}
