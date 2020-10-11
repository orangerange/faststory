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

use App\Controller\AppController;
use App\Utils\AppUtility;

/**
 * Static Icon controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class IconsController extends AppController
{
	public function initialize()
    {
        parent::initialize();

        $this->loadModel('ObjectProducts');
    }

	public function index() {
		$icons = $this->Icons->find('all');
		$this->set(compact('icons'));
	}

	public function input() {
        $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
		$icon =$this->Icons->newEntity();
		if($this->request->is('post')) {
			$Icon = $this->Icons->patchEntity($icon, $this->request->getData());
			if ($this->Icons->save($icon)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('icon', 'objects'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$icon = $this->Icons->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
            $Utils = new AppUtility();
            $layouts = $Utils->createObjectLayoutByCss($icon->get('css'));
			if($this->request->is(['patch', 'post', 'put'])) {
				$icon = $this->Icons->patchEntity($icon, $this->request->getData());
				if ($this->Icons->save($icon)) {
					$this->Flash->success(__('更新しました'));
//					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('icon','objects', 'layouts'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

    public function detail($id) {
        if (preg_match("/^[0-9]+$/", $id)) {
            if (!$icon = $this->Icons->findById($id)->first()) {
                throw new NotFoundException(NotFoundMessage);
            }
            $this->set(compact('icon'));
        } else{
            throw new NotFoundException(NotFoundMessage);
        }
    }

//	public function delete($id) {
//		if (preg_match("/^[0-9]+$/", $id)) {
//			die('削除');
////			$Icon = $this->Icons->get($id);
////			$this->Icons->delete($id);
//		} else {
//			die('存在しない');
//		}
//		$this->render(false,false);
//	}


}
