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
 * Static Logo controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class LogosController extends AdminAppController
{
	public function initialize()
    {
        parent::initialize();

        $this->loadModel('ObjectProducts');
    }

	public function index() {
		$logos = $this->Logos->find('all');
		$this->set(compact('logos'));
	}

	public function input() {
        $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
		$logo =$this->Logos->newEntity();
		if($this->request->is('post')) {
			$Logo = $this->Logos->patchEntity($logo, $this->request->getData());
			if ($this->Logos->save($logo)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('logo', 'objects'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$logo = $this->Logos->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.id' => 'ASC']);
            $Utils = new AppUtility();
            $layouts = $Utils->createObjectLayoutByCss($logo->get('css'));
			if($this->request->is(['patch', 'post', 'put'])) {
				$logo = $this->Logos->patchEntity($logo, $this->request->getData());
				if ($this->Logos->save($logo)) {
					$this->Flash->success(__('更新しました'));
//					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('logo','objects', 'layouts'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

    public function detail($id) {
        if (preg_match("/^[0-9]+$/", $id)) {
            if (!$logo = $this->Logos->findById($id)->first()) {
                throw new NotFoundException(NotFoundMessage);
            }
            $this->set(compact('logo'));
        } else{
            throw new NotFoundException(NotFoundMessage);
        }
    }

//	public function delete($id) {
//		if (preg_match("/^[0-9]+$/", $id)) {
//			die('削除');
////			$Logo = $this->Logos->get($id);
////			$this->Logos->delete($id);
//		} else {
//			die('存在しない');
//		}
//		$this->render(false,false);
//	}


}
