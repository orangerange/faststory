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
use App\Utils\AppUtility;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ObjectsController extends AppController
{

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Objects');
		$this->loadModel('Characters');
    }

    public function getCharacters() {
            $this->viewBuilder()->setLayout(false);
        // Ajax からのリクエストか、否かを確認
//        if($this->request->is("ajax")){
            $contentId = $this->request->getData('content_id');
            $characters = $this->Characters->find('list')->where(['content_id'=>$contentId]);
            $this->set(compact('characters'));

//        } else {
//            throw new NotFoundException(NotFoundMessage);
//        }
    }
}
