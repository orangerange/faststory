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

use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use App\Controller\Admin\AdminAppController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CharactersController extends AdminAppController
{
	public $helpers = array('Display');

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Contents');
		$this->loadModel('Parts');
		$this->loadModel('PartCategories');
		$this->loadModel('CharacterParts');
		$this->loadModel('Organizations');
		$this->loadModel('Ranks');
    }

	public function index() {
		$characters = $this->Characters->find('all')->order(['id' => 'ASC']);
		$this->set(compact('characters'));
	}

	public function input() {
		$organizations = $this->Organizations->find('list')->order(['id'=>'ASC']);
		$ranks = [];
		$contents = $this->Contents->find('list')->order(['id'=>'ASC']);
		$css = $this->Parts->find()->select('css')->order(['id'=>'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId(Configure::read('object_template_key.face'));
		$parts = [];
		$partsCss = [];
		foreach($partCategories as $_key=>$_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'html'])->where(['parts_category_no'=>$_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'css'])->where(['parts_category_no'=>$_value->id])->all();
		}
		$cssString = json_encode($partsCss);
		if($this->request->is('post')) {
			$data= $this->Characters->moldSetData($this->request->getData());
			foreach ($data['character_parts'] as $_key => $_value) {
				if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
					unset($data['character_parts'][$_key]);
				}
			}
			$character = $this->Characters->newEntity($data, ['associated' => ['CharacterParts']]);
			if($this->Characters->save($character)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('organizations', 'ranks', 'contents', 'partCategories', 'parts', 'css', 'cssString'));
	}

	public function edit($id) {
        $organizations = $this->Organizations->find('list')->order(['id'=>'ASC']);
        $ranks = [];
		$contents = $this->Contents->find('list');
		$css = $this->Parts->find()->select('css')->order(['id'=>'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId(Configure::read('object_template_key.face'));
		$parts = [];
		$partsCss = [];
		foreach($partCategories as $_key=>$_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'html'])->where(['parts_category_no'=>$_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'css'])->where(['parts_category_no'=>$_value->id]);
		}
		$cssString = json_encode($partsCss);
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$character = $this->Characters->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			};
			$partsSelected = $this->CharacterParts->findListByCharacterId($id)->toArray();

			$character = $this->Characters->moldGetData($character);
			$organizationId = $character->get('organization_id');
			if (isset($organizationId)) {
                $ranks = $this->Ranks->find('list')->where(['organization_id' => $organizationId])->order(['id'=>'ASC']);
            }
			if ($this->request->is(['patch', 'post', 'put'])) {
				$data= $this->Characters->moldSetData($this->request->getData());
				foreach ($data['character_parts'] as $_key => $_value) {
					if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
						unset($data['character_parts'][$_key]);
					}
				}
				$character = $this->Characters->patchEntity($character, $data);
				// 削除チェックボックスがチェックされている時
//				if (!empty($this->request->data['picture_delete'])) {
//					try {
//						$dir = realpath(ROOT . "/". $this->request->data['dir_before']);
//						$del_file = new File($dir . "/" . $this->request->data['picture_before']);
//						// ファイル削除処理実行
//						if ($del_file->delete()) {
//							$character->picture = null;
//							$character->dir= null;
//							$character->type = null;
//							$character->size = 0;
//						} else {
//							$character['picture'] = $this->request->data['picture_before'];
//							throw new RuntimeException('ファイルの削除ができませんでした.');
//						}
//					} catch (RuntimeException $e) {
//						$this->Flash->error(__($e->getMessage()));
//					}
//				}
//				// 新しいファイルが入力されたとき
//				if (!empty($this->request->data['picture']['name'])) {
//					// 古いファイルがあるとき
//					if (isset($this->request->data['dir_before'])) {
//						$dir = realpath(ROOT . "/" . $this->request->data['dir_before']);
//						$del_file = new File($dir . "/" . $this->request->data['picture_before']);
//						// ファイル削除処理実行
//						$del_file->delete();
//					}
//				}
				$this->CharacterParts->deleteByCharacterId($id);
				if ($this->Characters->save($character)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('organizations','ranks', 'contents', 'character', 'partCategories', 'parts', 'partsSelected', 'css', 'cssString'));
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$character = $this->Characters->get($id);
			$phrase = array();
			$phrase['sentence'] = 'サンプルサンプルサンプル\nあああああ';
			$this->set(compact('phrase', 'character'));
		} else{
			die('存在しない');
		}
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$content = $this->Characters->get($id);
			$this->Characters->delete($id);
		} else {
			die('存在しない');
		}
		$this->render(false,false);
	}

    public function copyCharacter($characterId)
    {
        if (preg_match("/^[0-9]+$/", $characterId)) {
            if (!$character = $this->Characters->findById($characterId)) {
                throw new NotFoundException(NotFoundMessage);
            }
            $characterData = array(
                'content_id' => $character->content_id,
                'organization_id' => $character->organization_id,
                'rank_id' => $character->rank_id,
                'name' => $character->name,
                'name_display' => $character->name_display,
                'name_color' => $character->name_color,
                'foreign_color' => $character->foreign_color,
                'picture' => $character->picture,
                'dir' => $character->dir,
                'type' => $character->type,
                'size' => $character->size,
                'html' => $character->html,
                'css' => $character->css,
                'html_speak' => $character->html_speak,
                'css_speak' => $character->css_speak,
                'css_body' => $character->css_body,
            );
            $characterData['character_parts'] = array();
            foreach ($character->character_parts as $characterPart) {
                $characterData['character_parts'][$characterPart->parts_category_no] ['type'] = $characterPart->type;
                $characterData['character_parts'][$characterPart->parts_category_no] ['parts_category_no'] = $characterPart->parts_category_no;
                $characterData['character_parts'][$characterPart->parts_category_no] ['parts_no'] = $characterPart->parts_no;
                $characterData['character_parts'][$characterPart->parts_category_no] ['parts_css'] = $characterPart->parts_css;
            }
            $character = $this->Characters->newEntity($characterData, ['associated' => ['CharacterParts']]);
            $this->Characters->save($character);
            return $this->redirect(
                ['controller' => 'characters', 'action' => 'edit', $character->id]
            );
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->render(false,false);
    }
}
