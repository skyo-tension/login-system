<?php
namespace app\controller;

require_once 'controller.php';

/**
 * ユーザー コントローラー
 *
 */
class welcome extends controller
{
    private $name = 'welcome';
    
    public function __construct(){
        parent::__construct();
    }

    public function index(){

        session_start();
        
        // セッション変数 $_SESSION["loggedin"]を確認。ログイン済だったらウェルカムページへリダイレクト
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: login");
            exit;
        }

        $welcome = new welcome();
        $this->logging($welcome);

        return $this->view($this->name, []);
    }

    public function __toString():string {
        return $this->name;
    }
}
