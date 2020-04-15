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
            $characterId = $this->request->getData('character_id');
            $sentence = $this->request->getData('sentence');
            $sentenceTranslate = $this->request->getData('sentence_translate');
            $sentenceKana = $this->request->getData('sentence_kana');
            $speak = $this->Objects->findSpeak($characterId);
            $character = $this->Characters->get($characterId);
            $this->set(['face'=>$speak['face'], 'body'=>$speak['body'], 'speech'=>$speak['speech'], 'sentence'=>$sentence, 'sentence_kana'=>$sentenceKana, 'sentence_translate'=>$sentenceTranslate, 'character'=>$character]);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    public function characterSpeakCss() {
        $this->autoRender = false;
        // Ajax からのリクエストか、否かを確認
        if ($this->request->is("ajax")) {
            $characterId = $this->request->getData('character_id');
            $speak = $this->Objects->findSpeak($characterId);
            $faceCss = $speak['face']->css;
            $faceId = $speak['face']->id;
            $faceWidth = $speak['face']->object_template->width;
            $faceHeight = $speak['face']->object_template->height;
            $util = new AppUtility();
            $faceCss = $util->addPreClassToCss($faceCss, '.object_' . $faceId);
            $faceCss = $this->_makeBaseCss('.object_' . $faceId, $faceWidth, $faceHeight, 'face') . ' ' . $faceCss;

            $bodyCss = $speak['body']->css;
            $bodyId = $speak['body']->id;
            $bodyWidth = $speak['body']->object_template->width;
            $bodyHeight = $speak['body']->object_template->height;
            $bodyCss = $util->addPreClassToCss($bodyCss, '.object_' . $bodyId);
            $bodyCss = $this->_makeBaseCss('.object_' . $bodyId, $bodyWidth, $bodyHeight, 'body') . ' ' . $bodyCss;

            $speechCss = $speak['speech']->css;
            $speechId = $speak['speech']->id;
            $speechWidth = $speak['speech']->object_template->width;
            $speechHeight = $speak['speech']->object_template->height;
            $speechCss = $util->addPreClassToCss($speechCss, '.object_' . $speechId);
            $speechCss = $this->_makeBaseCss('.object_' . $speechId, $speechWidth, $speechHeight, 'speech') . ' ' . $speechCss;

            $css = $faceCss . $bodyCss . $speechCss;
            $this->response->body($css);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    private function _makeBaseCss($baseClass, $width, $height, $speakType) {
        $this->autoRender = false;
        $baseCss = $baseClass . '{ width:' . $width . '%;' . ' height:' . $height . '%; position:absolute;';
        switch ($speakType) {
            case 'face':
                $baseCss .= ' top:2%; left:12.5%;';
                break;
            case 'body':
                $baseCss .= ' bottom:0%; left:10%;';
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
