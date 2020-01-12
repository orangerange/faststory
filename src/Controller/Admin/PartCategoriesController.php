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
class PartCategoriesController extends AppController
{
	public function initialize() {
		parent::initialize();
		$this->loadModel('ObjectTemplates');
	}

	public function index($templateId = 0, $objectType = 0) {
		$template = null;
		if (!empty($templateId)) {
			$template = $this->ObjectTemplates->findById($templateId)->first();
			if (!isset($template)) {
				throw new NotFoundException(NotFoundMessage);
			}
		} elseif(empty($objectType) || empty(Configure::read('object_type')[$objectType])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$partCategories = $this->PartCategories->findByType($templateId, $objectType);
		$this->set(compact('template', 'templateId', 'objectType', 'partCategories'));
	}

	public function input($templateId = 0, $objectType = 0) {
		$template = null;
		if (!empty($templateId)) {
			$template = $this->ObjectTemplates->findById($templateId)->first();
			if (!isset($template)) {
				throw new NotFoundException(NotFoundMessage);
			}
		} elseif(empty($objectType) || empty(Configure::read('object_type')[$objectType])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$category = $this->PartCategories->newEntity();
		if ($this->request->is('post')) {
			$category = $this->PartCategories->patchEntity($category, $this->request->getData());
			$category->sort_no = $this->PartCategories->findNextSortNo($templateId, $objectType);
			$category->template_id = $templateId;
			$category->object_type = $objectType;
			if ($this->PartCategories->save($category)) {
				$this->Flash->success(__('新規登録しました'));
				$category = $this->PartCategories->newEntity();
				return $this->redirect(['action' => 'input']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('template', 'templateId', 'objectType', 'template'));
	}

	public function edit($id, $templateId = 0, $objectType = 0) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$category = $this->PartCategories->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
			if ($category->template_id) {
				$templateId = $category->template_id;
				$template = $this->ObjectTemplates->findById($templateId)->first();
			}
			if ($category->object_type) {
				$objectType = $category->object_type;
			}
			if($this->request->is(['patch', 'post', 'put'])) {
				$category = $this->PartCategories->patchEntity($category, $this->request->getData());
				if ($this->PartCategories->save($category)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('template', 'templateId', 'objectType', 'category'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}
}