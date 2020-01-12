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
		$partCategories = $this->PartCategories->find()->order('sort_no')->all();
		$content = '';
		foreach($partCategories as $_category) {
			$content .= '.' . $_category->class_name . '{ ' . 'position: absolute; ' . 'z-index: ' . $_category->z_index . '; }';
		}
		return '<style type="text/css">' . $content . '</style>';
	}
	public function css($content, $preClass = null) {
		$content = AppUtility::addPreClassToCss($content, $preClass);
		return '<style type="text/css">' . $content . '</style>';
	}
}