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

use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
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
		$this->loadModel('Objects');
		$this->loadModel('Characters');
    }

    public function characterSpeakHtml() {
        $this->viewBuilder()->setLayout(false);
        // Ajax からのリクエストか、否かを確認
        if ($this->request->is("ajax")) {
            $phraseNo = $this->request->getData('phrase_no');
            $characterId = $this->request->getData('character_id');
            $sentence = $this->request->getData('sentence');
            $sentenceTranslate = $this->request->getData('sentence_translate');
            $sentenceKana = $this->request->getData('sentence_kana');
            $speak = $this->Objects->findSpeak($characterId);
            $character = $this->Characters->get($characterId);
            if (!isset($speak['face']->id) || !isset($speak['body']->id)) {
                $this->autoRender = false;
                $this->response->getBody()->write('');
            }
            $this->set(['face'=>$speak['face'], 'body'=>$speak['body'], 'speech'=>$speak['speech'], 'sentence'=>$sentence, 'sentence_kana'=>$sentenceKana, 'sentence_translate'=>$sentenceTranslate, 'character'=>$character, 'phraseNo'=>$phraseNo]);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    public function characterSpeakCss() {
        $this->autoRender = false;
        // Ajax からのリクエストか、否かを確認
        if ($this->request->is("ajax")) {
            $phraseNo = $this->request->getData('phrase_no');
            $characterId = $this->request->getData('character_id');
            $speak = $this->Objects->findSpeak($characterId);
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
            $util = new AppUtility();
            $faceCss = $util->addPreClassToCss($faceCss, '.face.object_' . $faceId);
            $faceCss = $this->_makeBaseCss('.face.object_' . $faceId, $faceWidth, $faceHeight, 'face', $faceRelLeft) . ' ' . $faceCss;

            $bodyCss = $speak['body']->css;
            $bodyCss = $util->addPreClassToCss($bodyCss, '.body.object_' . $bodyId);
            $bodyCss = $this->_makeBaseCss('.body.object_' . $bodyId, $bodyWidth, $bodyHeight, 'body', $faceRelLeft) . ' ' . $bodyCss;

            $speechCss = $speak['speech']->css;
            $speechCss = $util->addPreClassToCss($speechCss, '.speech.object_' . $speechId);
            $speechCss = $this->_makeBaseCss('.speech.object_' . $speechId, $speechWidth, $speechHeight, 'speech', $faceRelLeft) . ' ' . $speechCss;

            $css ='.character_speak_' . $phraseNo . '{left:10%; width:100%; height:100%; position:absolute;}';
            $css .= $faceCss . $bodyCss . $speechCss;
            $this->response->getBody()->write($css);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    private function _makeBaseCss($baseClass, $width, $height, $speakType, $faceRelLeft) {
        $this->autoRender = false;
        $baseCss = $baseClass . '{ width:' . $width . '%;' . ' height:' . $height . '%; position:absolute;';
        switch ($speakType) {
            case 'face':
                $baseCss .= ' top:10%; left:' . $faceRelLeft . '%;';
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
