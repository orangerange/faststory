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
class PartCategoriesController extends AdminAppController
{
	public function initialize() {
		parent::initialize();
		$this->loadModel('ObjectTemplates');
	}

	public function index($templateId = null) {
		if (isset($templateId)) {
			if (array_key_exists($templateId, Configure::read('object_template'))) {
				$template = Configure::read('object_template')[$templateId];
			} else {
				if (!$this->ObjectTemplates->exists(['id' => $templateId])) {
					throw new NotFoundException(NotFoundMessage);
				}
				$template = $this->ObjectTemplates->findById($templateId)->first();
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}

		$partCategories = $this->PartCategories->findByTemplateId($templateId);
		$this->set(compact('template', 'templateId', 'objectType', 'partCategories'));
	}

	public function input($templateId = null) {
		if (isset($templateId)) {
			if (array_key_exists($templateId, Configure::read('object_template'))) {
				$template = Configure::read('object_template')[$templateId];
			} else {
				if (!$this->ObjectTemplates->exists(['id' => $templateId])) {
					throw new NotFoundException(NotFoundMessage);
				}
				$template = $this->ObjectTemplates->findById($templateId)->first();
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}

		$category = $this->PartCategories->newEntity();
		if ($this->request->is('post')) {
			$category = $this->PartCategories->patchEntity($category, $this->request->getData());
			$category->sort_no = $this->PartCategories->findNextSortNo($templateId);
			$category->template_id = $templateId;
			if ($this->PartCategories->save($category)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('templateId', 'template'));
	}

	public function edit($id = null) {
		if (isset($id)) {
			if (!$this->PartCategories->exists(['id' => $id])) {
				throw new NotFoundException(NotFoundMessage);
			}
			$category = $this->PartCategories->findById($id)->first();

			if ($category->template_id) {
				$templateId = $category->template_id;
				if (array_key_exists($templateId, Configure::read('object_template'))) {
					$template = Configure::read('object_template')[$templateId];
				} else {
					if (!$this->ObjectTemplates->exists(['id' => $templateId])) {
						throw new NotFoundException(NotFoundMessage);
					}
					$template = $this->ObjectTemplates->findById($templateId)->first();
				}
			}

			if($this->request->is(['patch', 'post', 'put'])) {
				$category = $this->PartCategories->patchEntity($category, $this->request->getData());
				if ($this->PartCategories->save($category)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('id', 'template', 'templateId', 'category'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}
}
