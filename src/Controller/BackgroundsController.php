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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class BackgroundsController extends AppController
{
//	public function axiosChangeBackground() {
//        $this->viewBuilder()->setLayout(false);
//        $this->autoRender = false;
//        $bodyColor = '';
//        $html = '';
//        $css = '';
//
//        $id = $this->getRequest()->getQuery('id');
//        if (preg_match('/^[0-9]+$/', $id)) {
//            $query = $this->Backgrounds->find()->where(['id' => $id]);
//            if ($query->count() > 0) {
//                $background = $query->first();
//                $bodyColor = $background->get('body_color');
//                $html = $background->get('html');
//                $css = $background->get('css');
//            }
//        }
//        $result = ['body_color' => $bodyColor, 'html' => $html, 'css' => $css];
//        $this->response->getBody()->write(json_encode($result));
//	}
}
