<?php
namespace app\controller;

require_once 'controller.php';

/**
 * ログアウト コントローラー
 *
 */
class logout extends controller
{
    private $name = 'logout';
    
    public function __construct(){
        parent::__construct();
    }

    public function index(){

        session_start();
        
        //セッション変数の削除
        $_SESSION = array();
        //セッション削除
        session_destroy();

        //ログインページへリダイレクト
        header("location: login");
        exit;
    }

    public function __toString():string {
        return $this->name;
    }
}
