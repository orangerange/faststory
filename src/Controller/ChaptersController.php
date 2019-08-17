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

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

// メール送信
use Cake\Mailer\Email;

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
    }

	public function index($content_id = null) {
		if (preg_match("/^[0-9]+$/", $content_id)) {
			if (!$content = $this->Contents->findById($content_id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
			$chapters = $this->Chapters->find('all')->where(['Chapters.content_id'=>$content_id])->contain('Phrases')->toArray();
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set(compact('chapter', 'content_id', 'content'));
	}
		
	public function display($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$chapter = $this->Chapters->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			$this->set(compact('chapter'));
			$this->set('chapterId', $id);
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->render('display');
	}

	public function sendMail() {
		// メール送信処理
        $email = new Email("default");

        // 入力者へのメール
        $email->setFrom(["from@example.com"=>"送信元名"])
              ->setTo("goforthamdseekglory@yahoo.co.jp")
//              ->setCc("cc@example.com")
//              ->setBcc("bcc@example.com")
              ->setSubject("お問合せありがとうございます。")
              ->send("お問い合わせの本文です");
		
	}

}
