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

	public function initialize()
    {
        parent::initialize();
    }

	public function getBaseHtml() {
		$this->autoRender = false;
		if (!$this->request->is("ajax")) {
			throw new NotFoundException(NotFoundMessage);
		}
		$partsCategoryNo = $this->request->getData('parts_category_no');
		$class = Configure::read('parts_class')[$partsCategoryNo];
		$partsNo = $this->Parts->findNextPartsNoByPartsCategoryNo($partsCategoryNo);
		$html = '<div class="' . $class . ' ' . $class . '_' . $partsNo . '"></div>';
		$css = '.' . $class . '_' . $partsNo . '{}';
		$result = array('html'=>$html, 'css'=>$css);
		echo json_encode($result);
	}
}
