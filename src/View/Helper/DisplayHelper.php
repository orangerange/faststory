<?php
namespace App\View\Helper;
use Cake\View\Helper;

class DisplayHelper extends Helper {

    public function characterImage($character) {
		$dir = $character->dir;
		$dir = ltrim($dir, 'webroot\\');
		$path = '/' . $dir . $character->picture;
		
		return $path;
    }
}