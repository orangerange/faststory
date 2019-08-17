<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\Core\Configure;

class ConfigHelper extends Helper {

    public function read($setting) {
		return Configure::read($setting);
    }
}