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
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

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
		$this->Chapters = TableRegistry::get('Chapters');
		$this->Contents = TableRegistry::get('Contents');
		$this->Characters = TableRegistry::get('Characters');
		$this->Phrases = TableRegistry::get('Phrases');
    }

	public function index($content_id = null) {
		if (preg_match("/^[0-9]+$/", $content_id)) {
			if (!$content = $this->Contents->findById($content_id)->first()) {
				die('存在しない');
			}
			$chapters = $this->Chapters->find('all')->where(['Chapters.content_id'=>$content_id])->contain('Phrases')->toArray();
		} else {
			die('存在しない');
		}
		$this->set(compact('chapters', 'content_id', 'content'));
	}

	public function input($content_id=null) {
		$chapterNo = $this->Chapters->getLastChapterNo($content_id);
		if (preg_match("/^[0-9]+$/", $content_id)) {
			if (!$content = $this->Contents->findById($content_id)->first()) {
				die('存在しない');
			}
			$content_name = $content['name'];
			$characters = $this->Characters->find('list')->where(['content_id'=>$content_id]);
			if($this->request->is('post')) {
				$this->request->data['content_id'] = $content_id;
				$this->request->data['no'] = $this->Chapters->getLastChapterNo($content_id);
				$result = $this->Phrases->unsetEmptyDatum($this->request->data['phrases']);
				$this->request->data['phrases'] = $result['datum'];
				$openFlg = $result['open_flg'];
				$openFlg = array();
				$chapter = $this->Chapters->newEntity($this->request->data, ['associated' => ['Phrases']]);
				$this->Chapters->save($chapter);
			}
			$this->set(compact('chapterNo', 'characters', 'openFlg', 'content_id', 'content_name'));
		} else {
			die('存在しない');
		}
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$chapter = $this->Chapters->findById($id)) {
				die('存在しない');
			}
			$chapterNo = $chapter['no'];
			$content_id = $chapter['content_id'];
			$content_name = $chapter['content']['name'];
			$characters = $this->Characters->find('list')->where(['content_id'=>$chapter['content_id']]);
			$phraseNum = count($chapter['phrases']);
			$openFlg = array();
			for($i=0; $i<$phraseNum; $i++) {
				$openFlg[$i] = true;
			}
			if ($this->request->is(['patch', 'post', 'put'])) {
				for($i=0; $i<$phraseNum; $i++) {
					// 削除チェックボックスがチェックされている時
					if (!empty($this->request->data['phrases'][$i]['picture_delete'])) {
						try {
							$dir = realpath(ROOT . "/" . $this->request->data['phrases'][$i]['dir_before']);
							$del_file = new File($dir . "/" . $this->request->data['phrases'][$i]['picture_before']);
							// ファイル削除処理実行
							if ($del_file->delete()) {
								$this->request->data['phrases'][$i]['picture'] = null;
								$this->request->data['phrases'][$i]['dir']= null;
								$this->request->data['phrases'][$i]['type'] = null;
								$this->request->data['phrases'][$i]['size'] = 0;
								$this->request->data['phrases'][$i]['picture_before'] = null;
								$this->request->data['phrases'][$i]['dir_before']= null;
							} else {
								$this->request->data['phrases'][$i]['picture'] = $this->request->data['phrases'][$i]['picture_before'];
								throw new RuntimeException('ファイルの削除ができませんでした.');
							}
						} catch (RuntimeException $e) {
							$this->Flash->error(__($e->getMessage()));
						}
					}
					// 新しいファイルが入力されたとき
					if (!empty($this->request->data['phrases'][$i]['picture']['name'])) {
						// 古いファイルがあるとき
						if (isset($this->request->data['phrases'][$i]['dir_before'])) {
							$dir = realpath(ROOT . "/" . $this->request->data['phrases'][$i]['dir_before']);
							$del_file = new File($dir . "/" . $this->request->data['phrases'][$i]['picture_before']);
							// ファイル削除処理実行
							$del_file->delete();
						}
					}
				}
				$result = $this->Phrases->unsetEmptyDatum($this->request->data['phrases']);
				$this->request->data['phrases'] = $result['datum'];
				$openFlg = $result['open_flg'];
				//更新処理により削除されるレコードのID
				$deleteIds = $result['delete_ids'];
				$chapter = $this->Chapters->patchEntity($chapter, $this->request->data);

				$connection = ConnectionManager::get('default');
				// トランザクション開始
				$connection->begin();
				try {
					//最初に、更新で消えるphrasesレコードをを全て物理削除
					if (!empty($deleteIds)) {
						$this->Phrases->deleteByIds($deleteIds);
					}
					if ($this->Chapters->save($chapter)) {
						$this->Flash->success(__('更新しました'));
					} else {
						$this->Flash->error(__('更新に失敗しました'));
					}
					$connection->commit();
				} catch(\Exception $e) {
					echo $e->getMessage();
					 // ロールバック
					 $connection->rollback();
				}
			}
			$this->set(compact('openFlg', 'characters', 'chapter', 'chapterNo', 'content_id', 'content_name'));
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
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}

}
