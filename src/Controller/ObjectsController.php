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
namespace App\Controller;

use Cake\Filesystem\File;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;

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
		$this->loadModel('ObjectProducts');
        $this->loadModel('Phrases');
    }

    public function picture($objectId) {
        $this->autoRender = false;

        $query = $this->ObjectProducts->find()->select(['picture_content', 'mime'])->where(['id' => $objectId]);
        $picture = $query->first();

        $pictureContent = $picture->get('picture_content');
        $mime = $picture->get('mime');

        $response = $this->response->withType($mime);
        $response->getBody()->write(stream_get_contents($pictureContent));
        return $response;
    }
}
