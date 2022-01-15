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
namespace App\Controller\AdminAjax;

use App\Controller\Admin\AdminAppController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ObjectsController extends AdminAppController
{

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('ObjectProducts');
		$this->loadModel('Characters');
		$this->loadModel('Actions');
		$this->loadModel('ActionLayouts');
    }

    public function getCharacters() {
        $this->request->allowMethod(['ajax']);
        $this->viewBuilder()->setLayout(false);

        $contentId = $this->request->getData('content_id');
        $characters = $this->Characters->find('list')->where(['content_id'=>$contentId]);
        $this->set(compact('characters'));
    }

    public function addActions() {
        $this->request->allowMethod(['ajax']);
        $this->viewBuilder()->setLayout(false);
        $characters = $this->Characters->find('list');
        $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);

        $actionNum = $this->request->getData('action_num');
        $isTemplate = $this->request->getData('is_template');
        if (!isset($isTemplate)) {
            $isTemplate = false;
        }
        $this->set(compact('actionNum', 'characters', 'actions', 'isTemplate'));
    }

    public function getActionLayout() {
        $this->autoRender = false;
        $this->request->allowMethod(['ajax']);
        $objectTemplateId = $this->request->getData('object_template_id');
        $actionId = $this->request->getData('action_id');
        $layout = $this->ActionLayouts->find()->where(['object_template_id' => $objectTemplateId, 'action_id' => $actionId])->first();
        if (isset($layout)) {
            echo json_encode($layout);
        } else {
            echo '';
        }
    }
}
