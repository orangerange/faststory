<?php
namespace App\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\Datasource\ModelAwareTrait;
use App\Utils\AppUtility;

class DisplayHelper extends Helper {
	use ModelAwareTrait;
    public function imagePath($data) {
		$dir = $data->dir;
		$dir = ltrim($dir, 'webroot/');
		$path = '/' . $dir . $data->picture;

		return $path;
    }
	public function baseClassCss() {
		$this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
		$this->loadModel('PartCategories');
		$partCategories = $this->PartCategories->find()->contain('ObjectTemplates')->order('sort_no')->all();
		$content = '';
		foreach($partCategories as $_category) {
			$content .= '.' . $_category->object_template->class_name . ' .' . $_category->class_name . '{ ' . 'position: absolute; ' . 'z-index: ' . $_category->z_index . '; }';
		}
		return '<style type="text/css">' . $content . '</style>';
	}
	public function css($content, $preClass = null, $objName = null, $objWidth = null, $objHeight = null) {
        $content = AppUtility::addPreClassToCss($content, $preClass);
        if (isset($objName)) {
            $root = ':root {';
            if (isset($objWidth)) {
                $root .= '--' . $objName . '_width:calc(var(--phrase_object_width) * ' . $objWidth / 100 . ');';
            }
            if (isset($objHeight)) {
                $root .= '--' . $objName . '_height:calc(var(--phrase_object_height) * ' . $objHeight / 100 . ');';
            }
            $root .= '}';
            $content = !empty($content) ? $root . ' ' . $content : $root;
        }
		return '<style type="text/css">' . $content . '</style>';
	}

	public function phraseJs($scripts = array()) {
        $js = '<script type="text/javascript">' . VUE_PHRASE_SCRIPT_FIRST;
        foreach($scripts as $_phraseNum => $_script) {
            $js.= 'if (this.num ==' .  $_phraseNum . ') {';
            $js.= $_script;
            $js.= '}';
        }
        $js .= VUE_PHRASE_SCRIPT_LAST . '</script>';
        return $js;
    }
    public function movieJs($scripts = array()) {
        $js = '<script type="text/javascript">' . VUE_MOVIE_SCRIPT_FIRST;
        foreach($scripts as $_phraseNum => $_script) {
            $js.= 'if (this.num ==' .  $_phraseNum . ') {';
            $js.= $_script;
            $js.= '}';
        }
        $js .= VUE_MOVIE_SCRIPT_LAST . '</script>';
        return $js;
    }
    public function adminAnimateJs($i, $script = '') {
        $js = '<script type="text/javascript">' . "$(document).on('click', '.object_animate_" . $i . "', function() { " . $script . "})" . "</script>";
        return $js;
    }
    //画像データをBASE64でエンコード(jpg)
    function convertImageSource($imgData) {
        header('Content-type:image/jpg');
        echo $imgData;
    }
}
