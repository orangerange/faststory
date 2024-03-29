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
use App\Utils\AppUtility;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class LayoutsController extends AdminAppController
{

	public function initialize()
    {
        parent::initialize();
    }

    public function objectLayout() {
        $this->viewBuilder()->setLayout(false);
        $this->request->allowMethod(['ajax']);
        $css = $this->request->getData('css');
        $Utils = new AppUtility();
        $layouts = $Utils->createObjectLayoutByCss($css);
        $this->set(compact('layouts'));
    }
}
