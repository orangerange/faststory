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
    private $_isAdmin = '';

    public function initialize(array $config) {
        $this->_template = $config['template'];
        $this->_isAdmin = $config['is_admin'];
    }

    public function display($prefix = null, $no)
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
            $this->getController()->set(compact('chapter', 'scripts', 'prefix', 'no', 'nextFlg', 'backgrounds', 'bodyColor', 'chapters', 'chapterCount'));
            $this->getController()->set(['isAdmin' => $this->_isAdmin]);
        } else {
            throw new NotFoundException(NotFoundMessage);
        }
        $this->getController()->render($this->_template);
    }
}
