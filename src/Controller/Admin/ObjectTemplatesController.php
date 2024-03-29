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
class ObjectTemplatesController extends AdminAppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Actions');
    }

	public function index() {
		$objectTemplates = $this->ObjectTemplates->find()
//				->order('ObjectTemplates.sort_no')
//				->order('ObjectTemplates.id')
				->all();
		$this->set(compact('objectTemplates'));
	}

	public function input() {
		if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = $this->ObjectTemplates->unsetEmptyDatum($data);
			$template = $this->ObjectTemplates->newEntity($data);
			if ($this->ObjectTemplates->save($template)) {
				$this->Flash->success(__('新規登録しました'));
				$template = $this->ObjectTemplates->newEntity();
				return $this->redirect(['action' => 'input']);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('template'));
	}

	public function edit($id) {
		if (preg_match("/^[0-9]+$/", $id)) {
			if(!$template = $this->ObjectTemplates->findById($id)->first()) {
				throw new NotFoundException(NotFoundMessage);
			}
            $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
			if($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                $data = $this->ObjectTemplates->unsetEmptyDatum($data);
				$template = $this->ObjectTemplates->patchEntity($template, $data);
				if ($this->ObjectTemplates->save($template)) {
					$this->Flash->success(__('更新しました'));
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('template','actions'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set(compact('template'));
		$this->set('editFlg', true);
		$this->render('input');
	}
}
