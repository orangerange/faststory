<?php

namespace App\Utils;

/**
 * AppUtility.
 */
class AppUtility {

	public static function addPreClassToCss($css, $preClass=null) {
		if (isset($preClass)) {
			$css = $preClass . ' ' . $css;
			$arr = explode('}', $css);
			array_pop($arr);
			$css = implode('} ' . $preClass . ' ', $arr);
			$css .= '}';
		}
		return $css;
	}
}
