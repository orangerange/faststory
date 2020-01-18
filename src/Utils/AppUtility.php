<?php

namespace App\Utils;

use Cake\Filesystem\File;
use RuntimeException;
/**
 * AppUtility.
 */
class AppUtility {

	public function fileUpload($file = null, $dir = null, $limitFileSize = 1024 * 1024) {
		try {
			// ファイルを保存するフォルダ $dirの値のチェック
			if ($dir) {
				if (!file_exists($dir)) {
					throw new RuntimeException('指定のディレクトリがありません。');
				}
			} else {
				throw new RuntimeException('ディレクトリの指定がありません。');
			}

			// 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
			if (!isset($file['error']) || is_array($file['error'])) {
				throw new RuntimeException('Invalid parameters.');
			}

			// エラーのチェック
			switch ($file['error']) {
				case 0:
					break;
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			// ファイル情報取得
			$fileInfo = new File($file["tmp_name"]);

			// ファイルサイズのチェック
			if ($fileInfo->size() > $limitFileSize) {
				throw new RuntimeException('Exceeded filesize limit.');
			}

			// ファイルタイプのチェックし、拡張子を取得
			if (false === $ext = array_search($fileInfo->mime(), ['jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',], true)) {
				throw new RuntimeException('Invalid file format.');
			}

			// ファイル名の生成
//            $uploadFile = $file["name"] . "." . $ext;
			$uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

			// ファイルの移動
			if (!@move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}

			// 処理を抜けたら正常終了
//            echo 'File is uploaded successfully.';
		} catch (RuntimeException $e) {
			throw $e;
		}
		return $uploadFile;
	}

	/**
	 * 再帰的にディレクトリを削除する。
	 * @param string $dir ディレクトリ名（フルパス）
	 */
	public function removeDir($dir) {

		$cnt = 0;

		$handle = opendir($dir);
		if (!$handle) {
			return;
		}

		while (false !== ($item = readdir($handle))) {
			if ($item === "." || $item === "..") {
				continue;
			}

			$path = $dir . DIRECTORY_SEPARATOR . $item;

			if (is_dir($path)) {
				// 再帰的に削除
				$cnt = $cnt + removeDir($path);
			} else {
				// ファイルを削除
				unlink($path);
			}
		}
		closedir($handle);

		// ディレクトリを削除
		if (!rmdir($dir)) {
			return;
		}
	}

	public function addPreClassToCss($css, $preClass=null) {
		if (isset($preClass)) {
			$css = $preClass . ' ' . $css;
			$css = str_replace('}', '} ' . $preClass . ' ', $css);
			$css = rtrim($css, ' ' . $preClass);
		}
		return $css;
	}
}
