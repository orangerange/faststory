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

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
use Cake\Routing\Router;
use Cake\Core\Configure;
use App\Controller\AppController;
class AdminAppController extends AppController
{
    public function initialize()
    {
        parent::initialize();
//        $adminIps = Configure::read('admin_ip_addresses');
//        $clientIp = $this->getRequest()->clientIP();
//        if (!in_array($clientIp, $adminIps)) {
//            throw new ForbiddenException();
//        }
	}
}
