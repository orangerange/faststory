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

use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use App\Controller\Admin\AdminAppController;
use Cake\Http\Exception\NotFoundException;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ActionsController extends AdminAppController
{
	public function initialize() {
		parent::initialize();
		$this->loadModel('Actions');
	}

	public function index() {

		$actions = $this->Actions->find()->order(['sort_no' => 'ASC'])->all();
		$this->set(compact('actions'));
	}

	public function input() {
		$action = $this->Actions->newEntity();
		if ($this->request->is('post')) {
			$action = $this->Actions->patchEntity($action, $this->request->getData());
			$action->sort_no = $this->Actions->findNextSortNo();
			if ($this->Actions->save($action)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('action'));
	}

	public function edit($id = null) {
		if (isset($id)) {
			if (!$this->Actions->exists(['id' => $id])) {
				throw new NotFoundException(NotFoundMessage);
			}
			$action = $this->Actions->findById($id)->first();

			if($this->request->is(['patch', 'post', 'put'])) {
				$action = $this->Actions->patchEntity($action, $this->request->getData());
				if ($this->Actions->save($action)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('id','action'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}
}
