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
		$this->loadModel('ObjectProducts');
		$this->loadModel('ObjectTemplates');
		$this->loadModel('Contents');
		$this->loadModel('Parts');
		$this->loadModel('PartCategories');
		$this->loadModel('ObjectParts');
		$this->loadModel('Characters');
		$this->loadModel('CharacterParts');
    }

	public function index($templateId = null) {
		if (!isset($templateId) || !$this->ObjectTemplates->exists(['id'=>$templateId])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$template = $this->ObjectTemplates->findById($templateId)->first();
		$objects = $this->ObjectProducts->find('all')->where(['template_id'=>$templateId])->order(['id' => 'ASC']);
		$this->set(compact('template', 'objects'));
	}

	public function input($templateId = null) {
		if (!isset($templateId) || !$this->ObjectTemplates->exists(['id'=>$templateId])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$template = $this->ObjectTemplates->findById($templateId)->first();
		$contents = $this->Contents->find('list')->order(['id'=>'ASC']);
		$css = $this->Parts->find()->select('css')->where(['template_id'=>$templateId])->order(['id'=>'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId($templateId);
        $characters = $this->Characters->find('list')->where(['content_id'=>$template->content_id]);
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
			$object = $this->ObjectProducts->newEntity($data, ['associated' => ['ObjectParts']]);
			if($this->ObjectProducts->save($object)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template', 'contents', 'object', 'partCategories', 'parts', 'css', 'cssString'));
	}

	public function edit($id) {
		if (!isset($id) || !$this->ObjectProducts->exists(['id' => $id])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$object = $this->ObjectProducts->findById($id);
		$partsSelected = $this->ObjectParts->findListByObjectId($id)->toArray();
		$object = $this->ObjectProducts->moldGetData($object);
        $characters = $this->Characters->find('list')->where(['content_id'=>$object->content_id]);
		$templateId = $object->template_id;
		$template = $this->ObjectTemplates->findById($templateId)->first();
		$contents = $this->Contents->find('list');
		$css = $this->Parts->find()->select('css')->where(['template_id' => $templateId])->order(['id' => 'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId($templateId);
		$parts = [];
		$partsCss = [];
		foreach ($partCategories as $_key => $_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'html'])->where(['parts_category_no' => $_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'css'])->where(['parts_category_no' => $_value->id]);
		}
		$cssString = json_encode($partsCss);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();
			foreach ($data['object_parts'] as $_key => $_value) {
				if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
					unset($data['object_parts'][$_key]);
				}
			}
			$object = $this->ObjectProducts->patchEntity($object, $data);
			$this->ObjectParts->deleteByObjectId($id);
			if ($this->ObjectProducts->save($object)) {
				$this->Flash->success(__('更新しました'));
			} else {
				$this->Flash->error(__('更新に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template', 'contents', 'characters', 'object', 'partCategories', 'parts', 'partsSelected', 'css', 'cssString'));

		$this->set('editFlg', true);
		$this->render('input');
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$object = $this->ObjectProducts->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			$this->set(compact('object'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
	}

    public function copyFace($characterId)
    {
        if (preg_match("/^[0-9]+$/", $characterId)) {
            if (!$character = $this->Characters->findById($characterId)) {
                throw new NotFoundException(NotFoundMessage);
            }
            $objectData = array(
                'template_id' => Configure::read('object_template_key.face'),
                'content_id' => $character->content_id,
                'character_id' => $character->id,
                'name' => $character->name . '顔',
                'html' => $character->html,
                'css' => $character->css,
            );
            $objectData['object_parts'] = array();
            foreach ($character->character_parts as $characterPart) {
                $objectData['object_parts'][$characterPart->parts_category_no] ['parts_category_no'] = $characterPart->parts_category_no;
                $objectData['object_parts'][$characterPart->parts_category_no] ['parts_no'] = $characterPart->parts_no;
                $objectData['object_parts'][$characterPart->parts_category_no] ['parts_css'] = $characterPart->parts_css;
            }
            $object = $this->ObjectProducts->newEntity($objectData, ['associated' => ['ObjectParts']]);
            $this->ObjectProducts->save($object);
            return $this->redirect(
                ['controller' => 'objects', 'action' => 'edit', $object->id]
            );
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->render(false,false);
    }

    public function copyObject($objectId)
    {
        if (preg_match("/^[0-9]+$/", $objectId)) {
            if (!$object = $this->ObjectProducts->findById($objectId)) {
                throw new NotFoundException(NotFoundMessage);
            }
            $objectData = array(
                'template_id' => $object->template_id,
                'content_id' => $object->content_id,
                'object_id' => $object->id,
                'name' => $object->name,
                'html' => $object->html,
                'css' => $object->css,
            );
            $objectData['object_parts'] = array();
            foreach ($object->object_parts as $objectPart) {
                $objectData['object_parts'][$objectPart->parts_category_no] ['parts_category_no'] = $objectPart->parts_category_no;
                $objectData['object_parts'][$objectPart->parts_category_no] ['parts_no'] = $objectPart->parts_no;
                $objectData['object_parts'][$objectPart->parts_category_no] ['parts_css'] = $objectPart->parts_css;
            }
            $object = $this->ObjectProducts->newEntity($objectData, ['associated' => ['ObjectParts']]);
            $this->ObjectProducts->save($object);
            return $this->redirect(
                ['controller' => 'objects', 'action' => 'edit', $object->id]
            );
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->render(false,false);
    }

//	public function delete($id) {
//		if (preg_match("/^[0-9]+$/", $id)) {
//			$content = $this->ObjectProducts->get($id);
//			$this->ObjectProducts->delete($id);
//		} else {
//			throw new NotFoundException(NotFoundMessage);
//		}
//		$this->render(false,false);
//	}

}
