<?php
namespace App\View\Helper;
use Cake\View\Helper;

class CharacterHelper extends Helper {

    public function findById($id) {
		$dir = $data->dir;
		$dir = ltrim($dir, 'webroot/');
		$path = '/' . $dir . $data->picture;
		
		return $path;
    }
}