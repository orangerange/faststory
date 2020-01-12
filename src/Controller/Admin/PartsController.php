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

	public function initialize() {
		parent::initialize();
		$this->loadModel('Contents');
		$this->loadModel('PartCategories');
		$this->loadModel('ObjectTemplates');
	}

	public function index($templateId=null, $objectType = 0) {
		$template = null;
		if (!empty($templateId)) {
			$template = $this->ObjectTemplates->findById($templateId)->first();
			if (!isset($template)) {
				throw new NotFoundException(NotFoundMessage);
			}
		} elseif(empty($objectType) || empty(Configure::read('object_type')[$objectType])) {
			throw new NotFoundException(NotFoundMessage);
		}
		$parts = $this->Parts->findByType($templateId,$objectType);

		$this->set(compact('template', 'templateId', 'objectType', 'parts'));
	}

	public function input($partsCategoryNo=null, $partsNo=null, $templateId=null, $objectType = 0) {
		$template = null;
		//テンプレートID指定
		if (!empty($templateId)) {
			$template = $this->ObjectTemplates->findById($templateId)->first();
			if (!isset($template)) {
				throw new NotFoundException(NotFoundMessage);
			}
		//テンプレートIDの指定が無く、かつオブジェクト種類の指定が無い場合(複製時以外は不可)
		} elseif (empty($objectType) || empty(Configure::read('object_type')[$objectType])) {
			//複製時
			if (!empty($partsCategoryNo) && !empty($partsNo)) {
				if (preg_match("/^[0-9]+$/", $partsCategoryNo) && preg_match("/^[0-9]+$/", $partsNo)) {
					if (!$part = $this->Parts->findForCopy($partsCategoryNo, $partsNo)) {
						throw new NotFoundException(NotFoundMessage);
					}
					if ($part->template_id) {
						$templateId = $part->template_id;
						$template = $this->ObjectTemplates->findById($templateId)->first();
					}
					if ($part->object_type) {
						$objectType = $part->object_type;
					}
					$baseCss = $this->request->getData('base_css');
					if (isset($baseCss)) {
						$part->css = $baseCss;
					}
					$part = $this->Parts->moldGetData($part);
				} else {
					throw new NotFoundException(NotFoundMessage);
				}
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		}
		$partCategories = $this->PartCategories->findListByType($templateId, $objectType);
		if ($this->request->is(['post', 'put']) && !isset($baseCss)) {
			$data= $this->Parts->moldSetData($this->request->getData(), true);
			$data['template_id'] = $templateId;
			$data['object_type'] = $objectType;
			$part = $this->Parts->newEntity($data);
			if($this->Parts->save($part)) {
				$this->Flash->success(__('新規登録しました'));
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('template', 'templateId', 'objectType', 'partCategories', 'part'));
	}

	public function edit($id, $templateId = 0, $objectType = 0) {
		$this->autoRender = false;
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$part = $this->Parts->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			if ($this->request->is(['patch', 'post', 'put'])) {
			$data= $this->Parts->moldSetData($this->request->getData());
				$part = $this->Parts->patchEntity($part, $data);
				if ($this->Parts->save($part)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
				return $this->redirect(
					['controller' => 'Parts', 'action' => 'index', $templateId, $objectType]
				);
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
	}

	public function editCopy($partsCategoryNo = null, $partsNo = null, $templateId = 0, $objectType = 0) {
		$partCategories = $this->PartCategories->find('list', ['keyField'=>'id', 'valueField'=>'name'])->order(['sort_no'=>'ASC'])->all();
		if (isset($partsCategoryNo) && isset($partsNo)) {
			if (preg_match("/^[0-9]+$/", $partsCategoryNo) && preg_match("/^[0-9]+$/", $partsNo)) {
				if (!$part = $this->Parts->findForCopy($partsCategoryNo, $partsNo)) {
					throw new NotFoundException(NotFoundMessage);
				}
				if ($part->template_id) {
					$templateId = $part->template_id;
					$template = $this->ObjectTemplates->findById($templateId)->first();
				}
				if ($part->object_type) {
					$objectType = $part->object_type;
				}
				$baseCss = $this->request->getData('base_css');
				if (isset($baseCss)) {
					$part->css = $baseCss;
				}
				if ($this->request->is(['patch', 'post', 'put']) && !isset($baseCss)) {
					$data = $this->Parts->moldGetData($this->request->getData());
					$part = $this->Parts->patchEntity($part, $data);
					if ($this->Parts->save($part)) {
						$this->Flash->success(__('更新しました'));
					} else {
						$this->Flash->error(__('更新に失敗しました'));
					}
					return $this->redirect(
					['controller' => 'Parts', 'action' => 'index', $templateId, $objectType]
					);
				}
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		}
		$this->set(compact('template', 'templateId', 'objectType', 'partCategories', 'part'));
		$this->set('editFlg', true);
		$this->render('input');
	}

	public function detail($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$character = $this->Parts->get($id);
			$this->set(compact('character'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
	}

	public function delete($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			$content = $this->Parts->get($id);
			$this->Parts->delete($id);
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->render(false,false);
	}

}
