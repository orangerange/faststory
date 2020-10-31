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
namespace App\Controller\Admin;

use App\Controller\Admin\AdminAppController;
use App\Utils\AppUtility;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ContentsController extends AdminAppController
{
	public function initialize()
    {
        parent::initialize();

        $this->loadModel('ObjectProducts');
    }

	public function index() {
		//ini_set('default_charset', 'euc-jp');
		$contents = $this->Contents->find('all');
		$this->set(compact('contents'));
	}

	public function input() {
        $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
		$content =$this->Contents->newEntity();
		if($this->request->is('post')) {
			$content = $this->Contents->patchEntity($content, $this->request->getData());
			if($this->Contents->save($content)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('content', 'objects'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$content = $this->Contents->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
            $Utils = new AppUtility();
            $layouts = $Utils->createObjectLayoutByCss($content->get('thumbnail_css'));
			if($this->request->is(['patch', 'post', 'put'])) {
				$content = $this->Contents->patchEntity($content, $this->request->getData());
				if ($this->Contents->save($content)) {
					$this->Flash->success(__('更新しました'));
//					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('content', 'objects', 'layouts'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$content = $this->Contents->get($id);
//			$this->Contents->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}


}
