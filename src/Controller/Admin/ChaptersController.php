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

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use RuntimeException;
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
class ChaptersController extends AppController
{
    public $helpers = array('Display');

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Contents');
        $this->loadModel('Characters');
        $this->loadModel('Phrases');
        $this->loadModel('Objects');
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
        if (preg_match("/^[0-9]+$/", $contentId)) {
            if (!$content = $this->Contents->findById($contentId)->first()) {
                throw new NotFoundException(NotFoundMessage);
            }
            $objects = $this->Objects->find('all')->contain('ObjectTemplates')->where(['Objects.content_id' => $contentId])->order(['Objects.id' => 'ASC']);
            $contentName = $content['name'];
            $characters = $this->Characters->find('list')->where(['content_id' => $contentId]);
            $chapter = $this->Chapters->newEntity();
            if ($this->request->is('post')) {
                $this->request->withData('content_id', $contentId);
                $this->request->withData('no', $chapterNo);
                $result = $this->Phrases->unsetEmptyDatum($this->request->getData('phrases'));
                $this->request->withData('phrases', $result['datum']);
                $openFlg = $result['open_flg'];
//                $chapter = $this->Chapters->patchEntity($chapter, $this->request->getData(), ['associated' => ['Phrases']]);
//                $chapter = $this->Chapters->patchEntity($chapter, $this->request->getData());
                $chapter = $this->Chapters->newEntity($this->request->getData(), ['associated' => ['Phrases']]);
                if ($this->Chapters->save($chapter)) {
                    $this->Flash->success(__('新規登録しました'));
                } else {
                    $this->Flash->error(__('新規登録に失敗しました'));
                }
            }
            $this->set(compact('chapterNo', 'characters', 'openFlg', 'contentId', 'contentName', 'objects'));
        } else {
			throw new NotFoundException(NotFoundMessage);
		}
    }

    public function edit($id)
    {
        if (preg_match("/^[0-9]+$/", $id)) {
            if (!$chapter = $this->Chapters->findById($id)) {
                throw new NotFoundException(NotFoundMessage);
            }
            // オブジェクトレイアウト
            $layouts = array();
            foreach ($chapter['phrases'] as $_key => $_value) {
                $cssLayout = $_value->css;
                $layouts[$_key] = $this->Chapters->findObjectLayoutByCss($cssLayout);
            }
            $objects = $this->Objects->find('all')->contain('ObjectTemplates')->where(['Objects.content_id' => $chapter->content_id])->order(['Objects.id' => 'ASC']);
            $chapterNo = $chapter['no'];
            $contentId = $chapter['content_id'];
            $contentName = $chapter['content']['name'];
            $characters = $this->Characters->find('list')->where(['content_id' => $chapter['content_id']]);
            $phraseNum = count($chapter['phrases']);
            $openFlg = array();
            for ($i = 0; $i < $phraseNum; $i++) {
                $openFlg[$i] = true;
            }
            if ($this->request->is(['patch', 'post', 'put'])) {
                $postData = $this->request->getData();
                $result = $this->Phrases->unsetEmptyDatum($postData['phrases']);
                $this->request->withData('phrases', $result['datum']);
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
                    if ($this->Chapters->save($chapter)) {
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
            $this->set(compact('id', 'openFlg', 'characters', 'chapter', 'chapterNo', 'contentId', 'contentName', 'phraseNum', 'objects', 'layouts'));
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
        if ($this->request->is('post')) {
            $contentId = $this->request->data('content_id');
            $chapterId = $this->request->data('chapter_id');
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
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->render(false, false);
    }

}
