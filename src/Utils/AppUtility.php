<?php

namespace App\Utils;

use Cake\ORM\TableRegistry;

/**
 * AppUtility.
 */
class AppUtility {

	public static function addPreClassToCss($css, $preClass = null) {
		if (isset($preClass)) {
			$css = $preClass . ' ' . $css;
			$arr = explode('}', $css);
			array_pop($arr);
			$css = implode('} ' . $preClass . ' ', $arr);
			// start endの調整
            $css = str_replace($preClass . ' /*', '/*', $css);
            $css = str_replace('start*/', 'start*/' . $preClass . ' ', $css);
			$css .= '}';
		}
		return $css;
	}

    public function createObjectLayoutByCss($css) {
        $layout = array();
        // 発話
        $pattern = "/.character_speak_[0-9]+_[0-9]+{.*?}/";
        if (!preg_match_all($pattern, $css, $matches)) {
//            return false;
        }
        $num = 1;
        foreach ($matches[0] as $_match) {
            $LayoutCss = $_match;
            $layout[] = array('css'=>$LayoutCss, 'name'=>'発話オブジェクト(' . $num . ')', 'no'=>$num);
            $num++;
        }
        // それ以外
        $pattern = "/.object_[0-9]+_[0-9]+{.*?}/";
        if (!preg_match_all($pattern, $css, $matches)) {
//	        return false;
        }
        foreach ($matches[0] as $_match) {
            $LayoutCss = $_match;
            $pattern= "/^.object_[0-9]+_[0-9]+/";
            if (!preg_match($pattern, $LayoutCss, $idMatches)) {
//	        return false;
            }
            $pattern = "/[0-9]+$/";
            $extractedString = $idMatches[0];
            if (!preg_match($pattern, $extractedString, $idMatches2)) {
//	        return false;
            }
            $objectId = $idMatches2[0];
            $objectNo = str_replace(['.object_', '_' . $objectId], ['', ''], $extractedString);
            $ObjectProducts = TableRegistry::get('ObjectProducts');
            $object = $ObjectProducts->findById($objectId);
            $layout[] = array('css'=>$LayoutCss, 'name'=>$object->name . '_' . $objectNo, 'id'=>$objectId, 'no' => $objectNo);
        }
        return $layout;
    }
}
