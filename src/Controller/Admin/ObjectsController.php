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
use App\Controller\Admin\AdminAppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ObjectsController extends AdminAppController
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
		$this->loadModel('Actions');
		$this->loadModel('ActionLayouts');
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
		$css = $this->Parts->find()->select(['css', 'keyframe'])->where(['template_id'=>$templateId])->order(['id'=>'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId($templateId);
//        $characters = $this->Characters->find('list')->where(['content_id'=>$template->content_id]);
        $characters = $this->Characters->find('list');
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
		$parts = [];
		$partsCss = [];
		$partsPicture = [];
		foreach($partCategories as $_key=>$_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'html'])->where(['parts_category_no'=>$_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField'=>'parts_no', 'valueField'=>'css'])->where(['parts_category_no'=>$_value->id])->all();
            $partsPicture[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'id'])->where(['parts_category_no'=>$_value->id, 'picture_content IS NOT'=>NULL])->toArray();
		}
		$cssString = json_encode($partsCss);
		if($this->request->is('post')) {
			$data = $this->request->getData();
			$data['template_id'] = $templateId;
			$data = $this->ObjectProducts->unsetEmptyDatum($data);
            $actionLayoutCount = count($data['action_layouts']);
            // 画像登録
//            if (!empty($data['picture']['tmp_name'])) {
//                $file = new File($data['picture']['tmp_name']);
//                $pictureContent = $file->read();
//                $mime = $file->mime();
//                $data['picture_content'] = $pictureContent;
//                $data['mime'] = $mime;
//            } elseif(!empty($data['picture_content_id']) && empty($data['picture_del'])) {
//                $data['picture_content'] = $this->ObjectProducts->findPictureContentByID($data['picture_content_id']);
//            }

			$object = $this->ObjectProducts->newEntity($data, ['associated' => ['ObjectParts', 'ActionLayouts']]);
			if ($this->ObjectProducts->save($object, $data)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template', 'contents', 'object', 'partCategories', 'parts', 'css', 'cssString', 'characters', 'actions', 'actionLayoutCount', 'partsPicture'));
	}

	public function edit($id) {
		if (!isset($id) || !$this->ObjectProducts->exists(['id' => $id])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$object = $this->ObjectProducts->findById($id);
		$partsSelected = $this->ObjectParts->findListByObjectId($id)->toArray();
		$object = $this->ObjectProducts->moldGetData($object);

        $characters = $this->Characters->find('list');
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
		$templateId = $object->template_id;
		$template = $this->ObjectTemplates->findById($templateId)->first();
		$contents = $this->Contents->find('list');
		$css = $this->Parts->find()->select(['css', 'keyframe'])->where(['template_id' => $templateId])->order(['id' => 'ASC']);
		$partCategories = $this->PartCategories->findByTemplateId($templateId);
		$parts = [];
		$partsCss = [];
		$partsKeyframe = [];
		foreach ($partCategories as $_key => $_value) {
			$parts[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'html'])->where(['parts_category_no' => $_value->id])->toArray();
			$partsCss[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'css'])->where(['parts_category_no' => $_value->id]);
			$partsKeyframe[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'keyframe'])->where(['parts_category_no' => $_value->id]);
			$partsPicture[$_value->id] = $this->Parts->find('list', ['keyField' => 'parts_no', 'valueField' => 'id'])->where(['parts_category_no'=>$_value->id, 'picture_content IS NOT'=>NULL])->toArray();
		}
		$cssString = json_encode($partsCss);
		$keyframeString = json_encode($partsKeyframe);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();
            $data = $this->ObjectProducts->unsetEmptyDatum($data);
            // 画像登録
//            if (!empty($data['picture']['tmp_name'])) {
//                $file = new File($data['picture']['tmp_name']);
//                $pictureContent = $file->read();
//                $mime = $file->mime();
//                $data['picture_content'] = $pictureContent;
//                $data['mime'] = $mime;
//            } elseif(!empty($data['picture_content_id']) && empty($data['picture_del'])) {
//                $data['picture_content'] = $this->ObjectProducts->findPictureContentByID($data['picture_content_id']);
//            }

            // アクションレイアウトPOST値に前のデータが残っているのを解消
            unset($object['action_layouts']);
            $object = $this->ObjectProducts->patchEntity($object, $data);
			if ($this->ObjectProducts->save($object, $data)) {
				$this->Flash->success(__('更新しました'));
			} else {
				$this->Flash->error(__('更新に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template', 'contents', 'characters', 'object', 'partCategories', 'parts', 'partsSelected', 'css', 'cssString', 'keyframeString', 'actions', 'partsPicture'));

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
            $object = $this->ObjectProducts->newEntity($objectData, ['associated' => ['ObjectParts', 'ActionLayouts']]);
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
