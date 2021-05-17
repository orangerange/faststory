<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Display component
 */
class DisplayComponent extends Component
{
    private $_template = '';
    private $_movieTemplate = '';
    private $_isAdmin = '';

    public function initialize(array $config) {
        if (isset($config['template'])) {
            $this->_template = $config['template'];
        }
        if (isset($config['movie_template'])) {
            $this->_movieTemplate = $config['movie_template'];
        }
        $this->_isAdmin = $config['is_admin'];
    }

    public function display($prefix = null, $no, $isMovie = false, $firstPhraseNum = 1, $hasNoStoryShow = false, $timeBefore = 0)
    {
        $Chapters = TableRegistry::getTableLocator()->get('Chapters');
        $Backgrounds = TableRegistry::getTableLocator()->get('Backgrounds');

        if (isset($prefix) && preg_match("/^[0-9]+$/", $no)) {
            if (!$chapter = $Chapters->findByPrefixAndNo($prefix, $no)) {
                throw new NotFoundException(NotFoundMessage);
            }
            // チャプタ一覧取得
            $query = $Chapters->find('prefixAll', ['prefix' => $prefix]);
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
                        $query = $Backgrounds->find()->where(['id' => $_phrase->get('background_id')]);
                        if ($query->count() > 0) {
                            $backgrounds[$phraseNum]  = $query->first();
                        }
                    }
                }
                $phraseNum ++;
            }
            $bodyColor = null;
            if (isset($backgrounds[1])) {
                $firstBackground = $backgrounds[1];
                $bodyColor = $firstBackground->get('body_color');
            }
            $this->getController()->set(compact('chapter', 'scripts', 'prefix', 'no', 'nextFlg', 'backgrounds', 'bodyColor', 'chapters', 'chapterCount', 'hasNoStoryShow', 'timeBefore'));
            $this->getController()->set(['isAdmin' => $this->_isAdmin]);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        if ($isMovie) {
            $this->getController()->set(compact('firstPhraseNum'));
            $this->getController()->viewBuilder()->setLayout('movie');
            $this->getController()->render($this->_movieTemplate);
        } else {
            $this->getController()->render($this->_template);
        }
    }
}
