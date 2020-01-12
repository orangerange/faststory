<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use RuntimeException;
use App\Utils\AppUtility;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
use Cake\Routing\Router;
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
	
	// viewClassにSmartyViewを指定
	public $viewClass = 'App\View\SmartyView';
	public $helpers = array('Display', 'Config');

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
		$config = (object)Configure::read();
		$this->set(compact('config'));
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
		$url = Router::url();
		if (preg_match('/^\/admin/', $url)) {
			$this->viewBuilder()->setLayout('admin/default');
		}
	}

	public function fileUpload ($file = null,$dir = null, $limitFileSize = 1024 * 1024){
        try {
            // ファイルを保存するフォルダ $dirの値のチェック
            if ($dir){
                if(!file_exists($dir)){
                    throw new RuntimeException('指定のディレクトリがありません。');
                }
            } else {
                throw new RuntimeException('ディレクトリの指定がありません。');
            }
 
            // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
            if (!isset($file['error']) || is_array($file['error'])){
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
            if (false === $ext = array_search($fileInfo->mime(),
                                              ['jpg' => 'image/jpeg',
                                               'png' => 'image/png',
                                               'gif' => 'image/gif',],
                                              true)){
                throw new RuntimeException('Invalid file format.');
            }
 
            // ファイル名の生成
//            $uploadFile = $file["name"] . "." . $ext;
            $uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;
 
            // ファイルの移動
            if (!@move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)){
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
}
