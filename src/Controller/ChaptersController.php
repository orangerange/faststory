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
namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChaptersController extends AppController
{
	public $helpers = array('Display');

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Contents');
		$this->loadModel('Characters');
		$this->loadModel('Phrases');
		$this->loadModel('Backgrounds');
        $this->loadComponent('Display',['template' => 'display', 'is_admin' => false]);
    }

//	public function index($prefix= null) {
//		if (isset($prefix)) {
//			if (!$this->Contents->exists(['prefix'=>$prefix])) {
//				throw new NotFoundException(NotFoundMessage);
//			}
//			$content = $this->Contents->find('all')->where(['prefix'=>$prefix])->first();
//			$chapters = $this->Chapters->find('all')->where(['content_id'=>$content->id])->toArray();
//		} else {
//			throw new NotFoundException(NotFoundMessage);
//		}
//		// 背景色の設定
//		$bodyColor = INDEX_BODY_COLOR;
//		$this->set(compact('chapters', 'content_id', 'content', 'bodyColor'));
//	}

	public function display($prefix = null, $no) {
	    $this->Display->display($prefix, $no);
	}

    public function axiosList() {
        $this->viewBuilder()->setLayout(false);
        $this->autoRender = false;

        $isSuccess = false;
        $html = '';
        $content = null;

        $contentId = $this->getRequest()->getQuery('content_id');
        if (preg_match('/^[0-9]+$/', $contentId)) {
            $query = $this->Chapters->find()->where(['content_id' => $contentId]);
//            if ($query->count() > 0) {
                $chapters = $query->all();
                $isSuccess = true;
                $content = $this->Contents->get($contentId);
                $view = $this->createView();
                $view->set(['chapters'=>$chapters, 'content' => $content]);
                $html = $view->render('Chapters/axios_list');
//            }
        }
        $result = ['html' => $html, 'content' => $content, 'is_success' => $isSuccess];
        $this->response->getBody()->write(json_encode($result));
    }

    public function picture($phraseId, $isAdmin = false) {
        $this->autoRender = false;
	    if ($isAdmin) {
            $this->Phrases->setTable('admin_phrases');
        }
        $query = $this->Phrases->find()->select(['picture_content', 'mime'])->where(['id' => $phraseId]);
        $picture = $query->first();

        $pictureContent = $picture->get('picture_content');
        $mime = $picture->get('mime');

        $response = $this->response->withType($mime);
        $response->getBody()->write(stream_get_contents($pictureContent));
        return $response;
    }
}
