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

use Cake\Http\Exception\NotFoundException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChaptersController extends AppController
{
	public $helpers = array('Display');

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('Contents');
		$this->loadModel('Characters');
		$this->loadModel('Phrases');
		$this->loadModel('Backgrounds');
    }

	public function index($prefix= null) {
		if (isset($prefix)) {
			if (!$this->Contents->exists(['prefix'=>$prefix])) {
				throw new NotFoundException(NotFoundMessage);
			}
			$content = $this->Contents->find('all')->where(['prefix'=>$prefix])->first();
			$chapters = $this->Chapters->find('all')->where(['content_id'=>$content->id])->toArray();
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->set(compact('chapters', 'content_id', 'content'));
	}

	public function display($prefix = null, $no) {
		if (isset($prefix) && preg_match("/^[0-9]+$/", $no)) {
			if (!$chapter = $this->Chapters->findByPrefixAndNo($prefix, $no)) {
				throw new NotFoundException(NotFoundMessage);
			}
            // チャプタ一覧取得
            $query = $this->Chapters->find('prefixAll', ['prefix' => $prefix]);
            $chapters = $query->all();
            $chapterCount = $query->count();
            // 背景の取り出し
            $chapterId = $chapter->get('id');
			// アニメーション用js及び背景の取り出し
            $scripts = [];
            $backgrounds = [];
			$phraseNum = 1;
            foreach($chapter['phrases'] as $_phrase) {
                if (!empty($_phrase)) {
                    $scripts[$phraseNum] = $_phrase->js;
                    if (!empty($_phrase->get('background_id'))) {
                        $query = $this->Backgrounds->find()->where(['id' => $_phrase->get('background_id')]);
                        if ($query->count() > 0) {
                            $backgrounds[$phraseNum]  = $query->first();
                        }
                    }
                }
                $phraseNum ++;
            }
            $firstBackground = null;
            if (isset($backgrounds[1])) {
                $firstBackground = $backgrounds[1];
            }
			$this->set(compact('chapter', 'scripts', 'prefix', 'no', 'nextFlg', 'backgrounds', 'firstBackground', 'chapters', 'chapterCount'));
		} else {
			throw new NotFoundException(NotFoundMessage);
		}
		$this->render('display');
	}

}
