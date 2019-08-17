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
use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PartsController extends AppController
{
	public $helpers = array('Display', 'Config');

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Contents');
    }

	public function index() {
		$parts = $this->Parts->find()
				->order('Parts.parts_category_no')
				->order('Parts.id')
				->all();
		$this->set(compact('parts'));
	}

	public function input($id=null) {
		if (isset($id)) {
			if (preg_match("/^[0-9]+$/", $id)) {
				if (!$part = $this->Parts->findById($id)) {
					throw new NotFoundException(NotFoundMessage);
				}
				$part = $this->Parts->formatData($part);
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		}
		if ($this->request->is(['post'])) {
			$data = $this->request->getData();
			$part = $this->Parts->newEntity($data);
			if($this->Parts->save($part)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('part'));
	}

	public function edit($id) {
		$this->autoRender = false;
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$part = $this->Parts->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			if ($this->request->is(['patch', 'post', 'put'])) {
				$part = $this->Parts->patchEntity($part, $this->request->getData());
				if ($this->Parts->save($part)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
				return $this->redirect(
					['controller' => 'Parts', 'action' => 'index']
				);
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$character = $this->Parts->get($id);
			$this->set(compact('character'));
		} else{
			die('存在しない');
		}
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$content = $this->Parts->get($id);
//			$this->Parts->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}

}
