<?php
namespace App\View\Helper;
use Cake\View\Helper;

class DisplayHelper extends Helper {

    public function imagePath($data) {
		$dir = $data->dir;
		$dir = ltrim($dir, 'webroot/');
		$path = '/' . $dir . $data->picture;
		
		return $path;
    }
}