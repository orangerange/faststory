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
use Cake\Core\Configure;

use App\Controller\Admin\AdminAppController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class WordsController extends AdminAppController
{
	    public function initialize()
    {
        parent::initialize();
    }

	public function index() {
		//ini_set('default_charset', 'euc-jp');
			$words = $this->Words->find('all');
		$this->set(compact('words'));
	}

	public function split() {
		 $prefixes =  $this->Words->find()->where(['Words.type' => Configure::read('prefix_type_key.prefix')])->order(['LENGTH(name)'=>'DESC'])->all();
		$suffixes =  $this->Words->find()->where(['Words.type' => Configure::read('prefix_type_key.suffix')])->order(['LENGTH(name)'=>'DESC'])->all();
		if ($this->request->is('post')) {
			$data = $this->request->getData();
			$word = $data['word'];
			//接頭辞マッチ
			$prefix = array();
			$other = $word;
			$suffix = array();
			for ($i=1; $i <=3; $i++) {
				foreach($prefixes as $_prefix) {
					$words = preg_split('/^' . $_prefix['name'] . '/', $word);
					if (count($words) > 1) {
						$prefix[] = $_prefix;
						$word = $words[1];
						break;
					}
				}
			}
			for ($i=1; $i <=3; $i++) {
				foreach ($suffixes as $_suffix) {
					$words = preg_split('/' . $_suffix['name'] . '$/', $word);
					if (count($words) > 1) {
						$suffix[] = $_suffix;
						$word = $words[0];
						break;
					}
				}
			}
			$this->set(compact('prefix', 'suffix', 'word'));
		}
	}

	public function input() {
		$word =$this->Words->newEntity();
		if($this->request->is('post')) {
			$word = $this->Words->patchEntity($word, $this->request->getData());
			if($this->Words->save($word)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'input']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('word'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$word = $this->Words->findById($id)->first()) {
				die('存在しない');
			};
			if($this->request->is(['patch', 'post', 'put'])) {
				$word = $this->Words->patchEntity($word, $this->request->getData());
				if ($this->Words->save($word)) {
					$this->Flash->success(__('更新しました'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('word'));
		} else{
			die('存在しない');
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			die('削除');
//			$word = $this->Words->get($id);
//			$this->Words->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}


}
