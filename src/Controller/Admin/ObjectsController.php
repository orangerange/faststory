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
class ObjectsController extends AppController
{
	public $helpers = array('Display');

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('ObjectTemplates');
		$this->loadModel('Contents');
		$this->loadModel('Parts');
		$this->loadModel('PartCategories');
		$this->loadModel('ObjectParts');
    }

	public function index($templateId = 0) {
		if (empty($templateId) || !$this->ObjectTemplates->exists(['id'=>$templateId])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$objects = $this->Objects->find('all')->where(['template_id'=>$templateId])->order(['id' => 'ASC']);
		$this->set(compact('objects'));
	}

	public function input($templateId = 0) {
		$template = null;
		//テンプレートID指定
		if (!empty($templateId)) {
			$template = $this->ObjectTemplates->findById($templateId)->first();
			if (!isset($template)) {
				throw new NotFoundException(NotFoundMessage);
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$contents = $this->Contents->find('list')->order(['id'=>'ASC']);
		$css = $this->Parts->find()->select('css')->where(['template_id'=>$templateId])->order(['id'=>'ASC']);
		$partCategories = $this->PartCategories->findByType($templateId);
		$parts = [];
		$partsCss = [];
		foreach($partCategories as $_key=>$_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'html'])->where(['parts_category_no'=>$_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'css'])->where(['parts_category_no'=>$_value->id])->all();
		}
		$cssString = json_encode($partsCss);
		if($this->request->is('post')) {
			$data = $this->request->getData();
			$data['template_id'] = $templateId;
			foreach ($data['object_parts'] as $_key => $_value) {
				if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
					unset($data['object_parts'][$_key]);
				}
			}
			$object = $this->Objects->newEntity($data, ['associated' => ['ObjectParts']]);
			if($this->Objects->save($object)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template', 'contents', 'object', 'partCategories', 'parts', 'css', 'cssString'));
	}

	public function edit($id ) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$object = $this->Objects->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			};
			$partsSelected = $this->ObjectParts->findListByObjectId($id)->toArray();
			$object = $this->Objects->moldGetData($object);
			$templateId = $object->template_id;
			$template = $this->ObjectTemplates->findById($templateId)->first();
			$contents = $this->Contents->find('list');
			$css = $this->Parts->find()->select('css')->where(['template_id'=>$templateId])->order(['id'=>'ASC']);
			$partCategories = $this->PartCategories->findByType($templateId);
			$parts = [];
			$partsCss = [];
			foreach($partCategories as $_key=>$_value) {
				$parts[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'html'])->where(['parts_category_no'=>$_value->id])->toArray();
				$partsCss[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'css'])->where(['parts_category_no'=>$_value->id]);
			}
			$cssString = json_encode($partsCss);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$data = $this->request->getData();
				foreach ($data['object_parts'] as $_key => $_value) {
					if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
						unset($data['object_parts'][$_key]);
					}
				}
				$object = $this->Objects->patchEntity($object, $data);
				$this->ObjectParts->deleteByObjectId($id);
				if ($this->Objects->save($object)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('templateId', 'template','contents', 'object', 'partCategories', 'parts', 'partsSelected', 'css', 'cssString'));
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$object = $this->Objects->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			$this->set(compact('object'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$content = $this->Objects->get($id);
			$this->Objects->delete($id);
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->render(false,false);
	}

}
