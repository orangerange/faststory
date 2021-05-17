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

use App\Controller\Admin\AdminAppController;
use App\Utils\AppUtility;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ChaptersController extends AdminAppController
{
    public $helpers = array('Display');

    public $_displayColumns = [
        'background_id',
        'chapter_id',
        'no',
        'character_id',
        'object_usage',
        'speaker_name',
        'speaker_color',
        'sentence_color',
        'sentence',
        'sentence_translate',
        'sentence_kana',
        'html',
        'css',
        'js',
        'picture',
    ];
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Backgrounds');
        $this->loadModel('Contents');
        $this->loadModel('Characters');
        $this->loadModel('Phrases');
        $this->loadModel('ObjectProducts');
        $this->loadModel('Actions');
        $this->Phrases->setTable('admin_phrases');
        $this->loadComponent('Display',['template' => '/Chapters/display', 'movie_template' => '/Chapters/movie', 'is_admin' => true]);
    }

    public function index($contentId = null)
    {
        if (preg_match("/^[0-9]+$/", $contentId)) {
            if (!$content = $this->Contents->findById($contentId)->first()) {
                throw new NotFoundException(NotFoundMessage);
            }
            $chapters = $this->Chapters->find('all')->where(['Chapters.content_id' => $contentId])->contain('Phrases')->toArray();
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->set(compact('chapters', 'contentId', 'content'));
    }

    public function input($contentId = null)
    {
        $chapterNo = $this->Chapters->getLastChapterNo($contentId);
        $objectUsageArr = array_flip(Configure::read('object_usage_key'));
        $objectUsageStr = json_encode($objectUsageArr);
        if (preg_match("/^[0-9]+$/", $contentId)) {
            if (!$content = $this->Contents->findById($contentId)->first()) {
                throw new NotFoundException(NotFoundMessage);
            }
//            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->where(['ObjectProducts.content_id' => $contentId])->order(['ObjectProducts.template_id' => 'ASC', 'ObjectProducts.id' => 'ASC']);
            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.template_id' => 'ASC', 'ObjectProducts.id' => 'ASC']);
            $contentName = $content['name'];
            $characters = $this->Characters->find('list')->where(['content_id' => $contentId]);
            $backgrounds = $this->Backgrounds->find('list');
            $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
            $chapter = $this->Chapters->newEntity();
            if ($this->getRequest()->is('post')) {
                $postData = $this->getRequest()->getData();
                $postData['content_id'] = $contentId;
                $postData['no'] = $chapterNo;
                $result = $this->Phrases->unsetEmptyDatum($postData['phrases']);
                $postData['phrases'] = $result['datum'];
                $openFlg = $result['open_flg'];
                $chapter = $this->Chapters->patchEntity($chapter, $postData, ['associated' => ['Phrases']]);
                $connection = ConnectionManager::get('default');
                // トランザクション開始
                $connection->begin();
                try {
                    if ($this->Chapters->saveOrFail($chapter)) {
                        $this->Flash->success(__('新規登録しました'));
                        return $this->redirect(['controller' => 'chapters', 'action' => 'index', $contentId]);
                    } else {
                        $this->Flash->error(__('新規登録に失敗しました'));
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    // ロールバック
                    $connection->rollback();
                }
            }
            $this->set(compact('chapterNo', 'characters', 'backgrounds', 'openFlg', 'contentId', 'contentName', 'objects', 'objectUsageArr', 'objectUsageStr', 'actions'));
        } else {
			throw new NotFoundException(NotFoundMessage);
		}
    }

    public function edit($id)
    {
        $objectUsageArr = array_flip(Configure::read('object_usage_key'));
        $objectUsageStr = json_encode($objectUsageArr);
        if (preg_match("/^[0-9]+$/", $id)) {
            if (!$chapter = $this->Chapters->findById($id)) {
                throw new NotFoundException(NotFoundMessage);
            }
            // オブジェクトレイアウト
            $layouts = array();
            $objectCount = array();
            foreach ($chapter['phrases'] as $_key => $_value) {
                $cssLayout = $_value->css;
                $Utils = new AppUtility();
                $layout = $Utils->createObjectLayoutByCss($cssLayout);
                $layouts[$_key] = $layout;
                foreach ($layout as $_layout) {
                    if (isset($_layout['id']) && isset($_layout['no'])) {
                        if (!(isset($objectCount[$_layout['id']]) && $objectCount[$_layout['id']] >= $_layout['no'])) {
                            $objectCount[$_layout['id']] = $_layout['no'];
                        }
                    }
                }
            }
//            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->where(['ObjectProducts.content_id' => $chapter->content_id])->order(['ObjectProducts.template_id' => 'ASC', 'ObjectProducts.id' => 'ASC']);
            $objects = $this->ObjectProducts->find('all')->contain('ObjectTemplates')->order(['ObjectProducts.template_id' => 'ASC', 'ObjectProducts.id' => 'ASC']);
            $chapterNo = $chapter['no'];
            $contentId = $chapter['content_id'];
            $contentName = $chapter['content']['name'];
            $characters = $this->Characters->find('list')->where(['content_id' => $chapter['content_id']]);
            $backgrounds = $this->Backgrounds->find('list');
            $actions = $this->Actions->find('list')->order(['sort_no' => 'ASC']);
            $phraseNum = count($chapter['phrases']);
            $openFlg = array();
            for ($i = 0; $i < $phraseNum; $i++) {
                $openFlg[$i] = true;
            }
            if ($this->getRequest()->is(['patch', 'post', 'put'])) {
                $postData = $this->getRequest()->getData();
                $result = $this->Phrases->unsetEmptyDatum($postData['phrases']);
                $postData['phrases'] = $result['datum'];
                $openFlg = $result['open_flg'];
                //更新処理により削除されるレコードのID
                $deleteIds = $result['delete_ids'];
                $chapter = $this->Chapters->patchEntity($chapter, $postData);

                $connection = ConnectionManager::get('default');
                // トランザクション開始
                $connection->begin();
                try {
                    //最初に、更新で消えるphrasesレコードをを全て物理削除
                    $this->Phrases->deleteByChapterId($id);
                    if ($this->Chapters->saveOrFail($chapter)) {
                        $this->Flash->success(__('更新しました'));
                    } else {
                        $this->Flash->error(__('更新に失敗しました'));
                    }
                    $connection->commit();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    // ロールバック
                    $connection->rollback();
                }
            }
            $this->set(compact('id', 'openFlg', 'characters', 'backgrounds', 'chapter', 'chapterNo', 'contentId', 'contentName', 'phraseNum', 'objects', 'layouts', 'objectCount', 'objectUsageArr', 'objectUsageStr', 'actions'));
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->set('editFlg', true);
        $this->render('input');
    }

    public function detail($id)
    {
        if (preg_match("/^[0-9]+$/", $id)) {
            $character = $this->Characters->get($id);
            $this->set(compact('character'));
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
    }

    public function delete()
    {
        $contentId = $this->getRequest()->getData('content_id');
        $chapterId = $this->getRequest()->getData('chapter_id');
        $connection = ConnectionManager::get('default');
        // トランザクション開始
        $connection->begin();
        try {
            if (!$this->Chapters->deleteById($chapterId)) {
                throw new NotFoundException(NotFoundMessage);
            };
            if (!$this->Phrases->deleteByChapterId($chapterId)) {
                throw new NotFoundException(NotFoundMessage);
            };
            $connection->commit();
            $this->Flash->success(__('削除しました'));
            return $this->redirect(['controller' => 'chapters', 'action' => 'index', $contentId]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            // ロールバック
            $connection->rollback();
        }
        $this->render(false, false);
    }

    public function frontCopy()
    {
//        $this->getRequest()->allowMethod(['post']);
        $contentId = $this->getRequest()->getData('content_id');
        $chapterId = $this->getRequest()->getData('chapter_id');
        $connection = ConnectionManager::get('default');
        // トランザクション開始
        $connection->begin();
        try {
            // テーブル削除
            $sql = 'DELETE FROM phrases WHERE chapter_id = ' .  (integer)$chapterId;
            $results = $connection->execute($sql);
            // テーブルコピー
            $sql = 'INSERT INTO phrases (' . implode(',', $this->_displayColumns) . ') SELECT ' . implode(',', $this->_displayColumns) . ' FROM admin_phrases WHERE chapter_id = ' .  (integer)$chapterId;
            $results = $connection->execute($sql);
            $connection->commit();
            $this->Flash->success(__('反映しました'));
            return $this->redirect(['controller' => 'chapters', 'action' => 'edit', $chapterId]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            // ロールバック
            $connection->rollback();
        }
        $this->render(false, false);
    }

    // 管理側表示用メソッド
    public function display($prefix = null, $no) {
        $this->viewBuilder()->setLayout('default');
        $this->Display->display($prefix, $no);
    }

    public function movie($prefix = null, $no = 1, $firstPhraseNo = 1, $hasNoStoryShow = false, $timeBefore = 0) {
        $this->viewBuilder()->setLayout('default');
        $this->Display->display($prefix, $no, true, $firstPhraseNo, $hasNoStoryShow, $timeBefore);
    }
}
