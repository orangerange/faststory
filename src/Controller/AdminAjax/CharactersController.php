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

use App\Controller\AppController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CharactersController extends AppController
{

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Ranks');
    }

    public function getRankOption() {
        $this->request->allowMethod(['ajax']);
        $organizationId = $this->request->getData('organization_id');
        $ranks = $this->Ranks->find('list')->where(['organization_id'=>$organizationId]);
        $this->set(compact('ranks'));
        return;
    }
}
