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
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;
use Exception;
use App\Controller\AppController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CharactersController extends AppController
{
	public $helpers = array('Display');

	public function initialize()
    {
        parent::initialize();
		$this->Contents = TableRegistry::get('Contents');
    }

	public function index() {
		$characters = $this->Characters->find('all');
		$this->set(compact('characters'));
	}

	public function input() {
		$contents = $this->Contents->find('list');
		$character =$this->Characters->newEntity();
		if($this->request->is('post')) {
			$character = $this->Characters->patchEntity($character, $this->request->data);
			if($this->Characters->save($character)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('contents'));
		$this->set(compact('character'));
	}

	public function edit($id) {
		$contents = $this->Contents->find('list');
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$character = $this->Characters->findById($id)->first()) {
				die('存在しない');
			};
			if ($this->request->is(['patch', 'post', 'put'])) {
				$data = $this->request->data;
				$character = $this->Characters->patchEntity($character, $data);
				// 削除チェックボックスがチェックされている時
				if (!empty($this->request->data['picture_delete'])) {
					try {
						$dir = realpath(ROOT . "/". $this->request->data['dir_before']);
						$del_file = new File($dir . "/" . $this->request->data['picture_before']);
						// ファイル削除処理実行
						if ($del_file->delete()) {
							$character->picture = null;
							$character->dir= null;
							$character->type = null;
							$character->size = 0;
						} else {
							$character['picture'] = $this->request->data['picture_before'];
							throw new RuntimeException('ファイルの削除ができませんでした.');
						}
					} catch (RuntimeException $e) {
						$this->Flash->error(__($e->getMessage()));
					}
				}
				// 新しいファイルが入力されたとき
				if (!empty($this->request->data['picture']['name'])) {
					// 古いファイルがあるとき
					if (isset($this->request->data['dir_before'])) {
						$dir = realpath(ROOT . "/" . $this->request->data['dir_before']);
						$del_file = new File($dir . "/" . $this->request->data['picture_before']);
						// ファイル削除処理実行
						$del_file->delete();
					}
				}
				if ($this->Characters->save($character)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('contents'));
			$this->set(compact('character'));
		} else {
			die('存在しない');
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$character = $this->Characters->get($id);
			$this->set(compact('character'));
		} else{
			die('存在しない');
		}
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$content = $this->Characters->get($id);
//			$this->Characters->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}

}
