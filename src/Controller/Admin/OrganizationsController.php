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

/**
 * Static organization controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OrganizationsController extends AdminAppController
{
	public function initialize()
    {
        parent::initialize();
    }

	public function index() {
		$organizations = $this->Organizations->find('all');
		$this->set(compact('organizations'));
	}

	public function input() {
		$organization =$this->Organizations->newEntity();
		if($this->request->is('post')) {
			$organization = $this->Organizations->patchEntity($organization, $this->request->getData());
			if($this->Organizations->save($organization)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('organization'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$organization = $this->Organizations->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			};
			if($this->request->is(['patch', 'post', 'put'])) {
				$organization = $this->Organizations->patchEntity($organization, $this->request->getData());
				if ($this->Organizations->save($organization)) {
					$this->Flash->success(__('更新しました'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('organization'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$organization = $this->Organizations->get($id);
//			$this->Organizations->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}


}
