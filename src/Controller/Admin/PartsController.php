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
class PartsController extends AdminAppController
{
	public $helpers = array('Display', 'Config');

	public function initialize() {
		parent::initialize();
		$this->loadModel('Contents');
		$this->loadModel('PartCategories');
		$this->loadModel('ObjectTemplates');
	}

	public function index($templateId=null) {
        if (isset($templateId)) {
            if (!$this->ObjectTemplates->exists(['id' => $templateId])) {
                throw new NotFoundException(NotFoundMessage);
            }
            $template = $this->ObjectTemplates->findById($templateId)->first();
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
		$parts = $this->Parts->findByTemplateId($templateId);
		$this->set(compact('template', 'templateId', 'parts', 'script'));
	}

	public function input($templateId=null, $partsCategoryNo=null, $partsNo=null) {
		$template = null;
		//複製時
		if (isset($partsCategoryNo) && isset($partsNo)) {
			if (preg_match("/^[0-9]+$/", $partsCategoryNo) && preg_match("/^[0-9]+$/", $partsNo)) {
				if (!$part = $this->Parts->findForCopy($partsCategoryNo, $partsNo)) {
					throw new NotFoundException(NotFoundMessage);
				}
				$templateId = $part->template_id;
                $template = $this->ObjectTemplates->findById($templateId)->first();

				$baseCss = $this->request->getData('base_css');
				if (isset($baseCss)) {
					$part->css = $baseCss;
				}
				$part = $this->Parts->moldGetData($part);
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		//テンプレートID指定
		} elseif (isset($templateId)) {
			if (array_key_exists($templateId, Configure::read('object_template'))) {
				$template = Configure::read('object_template')[$templateId];
			}
			else {
				if (!$this->ObjectTemplates->exists(['id'=>$templateId])) {
					throw new NotFoundException(NotFoundMessage);
				}
				$template = $this->ObjectTemplates->findById($templateId)->first();
			}
		}

		$partCategories = $this->PartCategories->findListByTemplateId($templateId);
		if ($this->request->is(['post', 'put']) && !isset($baseCss)) {
			$data= $this->Parts->moldSetData($this->request->getData(), true);
			$data['template_id'] = $templateId;
			$part = $this->Parts->newEntity($data);
			if ($this->Parts->save($part, $data)) {
				$this->Flash->success(__('新規登録しました'));
                return $this->redirect(
                    ['controller' => 'Parts', 'action' => 'index', $templateId]
                );
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('template', 'templateId', 'partCategories', 'part'));
	}

	public function edit($id) {
		$this->autoRender = false;
		if (preg_match("/^[0-9]+$/", $id)) {
			if (!$part = $this->Parts->findById($id)) {
				throw new NotFoundException(NotFoundMessage);
			}
			if ($this->request->is(['patch', 'post', 'put'])) {
			$data= $this->Parts->moldSetData($this->request->getData());
				$part = $this->Parts->patchEntity($part, $data);
				if ($this->Parts->save($part, $data)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
				return $this->redirect(
					['controller' => 'Parts', 'action' => 'index', $part->template_id]
				);
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
	}

	public function editCopy($partsCategoryNo = null, $partsNo = null) {
		$partCategories = $this->PartCategories->find('list', ['keyField'=>'id', 'valueField'=>'name'])->order(['sort_no'=>'ASC'])->all();
		//複製時
		if (isset($partsCategoryNo) && isset($partsNo)) {
			if (preg_match("/^[0-9]+$/", $partsCategoryNo) && preg_match("/^[0-9]+$/", $partsNo)) {
				if (!$part = $this->Parts->findForCopy($partsCategoryNo, $partsNo)) {
					throw new NotFoundException(NotFoundMessage);
				}
				$templateId = $part->template_id;
                $template = $this->ObjectTemplates->findById($templateId)->first();

				$baseCss = $this->request->getData('base_css');
				if (isset($baseCss)) {
					$part->css = $baseCss;
				}
				if ($this->request->is(['patch', 'post', 'put']) && !isset($baseCss)) {
					$data = $this->Parts->moldGetData($this->request->getData());
					$part = $this->Parts->patchEntity($part, $data);
                    if ($this->Parts->save($part, $data)) {
						$this->Flash->success(__('更新しました'));
					} else {
						$this->Flash->error(__('更新に失敗しました'));
					}
					return $this->redirect(
					    ['controller' => 'Parts', 'action' => 'index', $templateId]
					);
				}
			} else {
				throw new NotFoundException(NotFoundMessage);
			}
		} else {
			throw new NotFoundException(NotFoundMessage);
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
