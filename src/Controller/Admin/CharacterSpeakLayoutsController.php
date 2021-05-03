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
 * Static characterSpeakLayout controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CharacterSpeakLayoutsController extends AdminAppController
{
	public function initialize()
    {
        parent::initialize();

        $this->loadModel('Characters');
        $this->loadModel('Actions');
    }

	public function index() {
        $characters = $this->Characters->find('list')->toArray();
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC'])->toArray();
		$characterSpeakLayouts = $this->CharacterSpeakLayouts->find('all');
		$this->set(compact('characterSpeakLayouts', 'characters', 'actions'));
	}

	public function input() {
        $characters = $this->Characters->find('list');
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
		$characterSpeakLayout =$this->CharacterSpeakLayouts->newEntity();
		if($this->request->is('post')) {
			$characterSpeakLayout = $this->CharacterSpeakLayouts->patchEntity($characterSpeakLayout, $this->request->getData());
			if($this->CharacterSpeakLayouts->save($characterSpeakLayout)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('characterSpeakLayout', 'characters', 'actions'));
	}

	public function edit($id) {
        $characters = $this->Characters->find('list');
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$characterSpeakLayout = $this->CharacterSpeakLayouts->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
            $Utils = new AppUtility();
			if($this->request->is(['patch', 'post', 'put'])) {
				$characterSpeakLayout = $this->CharacterSpeakLayouts->patchEntity($characterSpeakLayout, $this->request->getData());
				if ($this->CharacterSpeakLayouts->save($characterSpeakLayout)) {
					$this->Flash->success(__('更新しました'));
//					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('characterSpeakLayout', 'characters', 'actions'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$characterSpeakLayout = $this->CharacterSpeakLayouts->get($id);
//			$this->CharacterSpeakLayouts->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}


}
