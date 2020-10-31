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
class RanksController extends AdminAppController
{
	public function initialize() {
		parent::initialize();
		$this->loadModel('Organizations');
		$this->loadModel('Objects');
	}

	public function index($organizationId = null) {
		if (isset($organizationId)) {
            if (!$this->Organizations->exists(['id' => $organizationId])) {
                throw new NotFoundException(NotFoundMessage);
            }
            $organization = $this->Organizations->findById($organizationId)->first();
		} else {
			throw new NotFoundException(NotFoundMessage);
		}

		$ranks = $this->Ranks->findByOrganizationId($organizationId);
		$this->set(compact('organizationId','organization','ranks'));
	}

	public function input($organizationId = null) {
		if (isset($organizationId)) {
            if (!$this->Organizations->exists(['id' => $organizationId])) {
                throw new NotFoundException(NotFoundMessage);
            }
            $organization = $this->Organizations->findById($organizationId)->first();
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
        $badges = $this->Objects->find('list')->where(['template_id' => OBJECT_TEMPLATE_BADGE])->order(['id'=>'ASC']);
		$rank = $this->Ranks->newEntity();
		if ($this->request->is('post')) {
			$rank = $this->Ranks->patchEntity($rank, $this->request->getData());
            $rank->sort_no = $this->Ranks->findNextSortNo($organizationId);
			$rank->organization_id = $organizationId;
			if ($this->Ranks->save($rank)) {
				$this->Flash->success(__('新規登録しました'));
				return $this->redirect(['action' => 'index', $organizationId]);
			} else {
				$this->Flash->error(__('新規登録に失敗しました'));
			}
		}
		$this->set(compact('organizationId', 'organization', 'badges'));
	}

	public function edit($id = null) {
		if (isset($id)) {
			if (!$this->Ranks->exists(['id' => $id])) {
				throw new NotFoundException(NotFoundMessage);
			}
			$rank = $this->Ranks->findById($id)->first();

            $organizationId = $rank->get('organization_id');
            if (!$this->Organizations->exists(['id' => $organizationId])) {
                throw new NotFoundException(NotFoundMessage);
            }
            $badges = $this->Objects->find('list')->where(['template_id' => OBJECT_TEMPLATE_BADGE])->order(['id'=>'ASC']);
            $organization = $this->Organizations->findById($organizationId)->first();

			if($this->request->is(['patch', 'post', 'put'])) {
				$rank = $this->Ranks->patchEntity($rank, $this->request->getData());
				if ($this->Ranks->save($rank)) {
					$this->Flash->success(__('更新しました'));
                    return $this->redirect(['action' => 'index', $organizationId]);
				} else {
					$this->Flash->error(__('更新に失敗しました'));
				}
			}
			$this->set(compact('id', 'organization', 'organizationId', 'rank', 'badges'));
		} else{
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set('editFlg', true);
		$this->render('input');
	}
}
