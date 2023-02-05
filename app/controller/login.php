<?php
namespace app\controller;

require_once 'controller.php';
require_once dirname ( __FILE__ ) . '/../model/UsersModel.php';

use app\model\UsersModel;
use app\utility\utility;

/**
 * ログイン コントローラー
 *
 */
class login extends controller
{
    private $name = 'login';
    private $datas = [
        'name' => '',
        'password' => '',
    ];
    private $loginErr = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        session_start();

        // セッションにトークンセット
        Utility::setToken();

        $login = new login();
        $this->logging($login);

        return $this->view($this->name, [
            'name' => '',
            'password' => ''
        ]);
    }

    public function post()
    {
        session_start();
        
        // CSRF対策
        utility::checkToken();

        // POSTデータ取得
        foreach($this->datas as $key => $tmp)
        {
            $value = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
            $datas[$key] = $value;
            $this->logging($value);
        }

        // バリデーションチェック
        $errors = Utility::validation($datas, false);

        $usersModel = new UsersModel();
        
        // エラーがなければユーザーネームから該当するユーザー情報を取得
        if (empty($errors))
        {
            $user = $usersModel->select($datas['name']);
            
            //パスワードがあっているか確認
            if (password_verify($datas['password'],$user['password']))
            {
                //セッションIDをふりなおす
                session_regenerate_id(true);
                //セッション変数にログイン情報を格納
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["name"] = $user['name'];
                //ウェルカムページへリダイレクト
                header("location: welcome");
                exit();
            } else {
                $this->loginErr = 'ユーザー名かパスワードが無効です。';
            }
        }
        else {
            $this->loginErr = 'ユーザー名かパスワードが無効です。';
        }

        return $this->view($this->name, [
            'name' => $datas['name'],
            'password' => $datas['password'],
            'errors' => $errors,
            'loginErr' => $this->loginErr
        ]);
    }

    public function __toString():string
    {
        return $this->name;
    }
}
