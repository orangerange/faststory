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
use Cake\Http\Exception\NotFoundException;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class RanksController extends AppController
{

	public function initialize()
    {
        parent::initialize();
    }

	public function sort() {
		$this->autoRender = false;
        $this->request->allowMethod(['ajax']);

		$items = $this->request->getData('items');
		$sortIds = explode(',', $items);
		$sortNo = 1;
		$rank = $this->Ranks->newEntity();
		foreach($sortIds as $_id) {
			$data = $this->Ranks->patchEntity($rank, array('id'=>$_id, 'sort_no'=>$sortNo));
			$this->Ranks->save($data);
			$sortNo++;
		}
		$result = array('test'=>$data);
		echo json_encode($result);
	}
}
