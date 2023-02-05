<?php
namespace app\controller;

require_once 'controller.php';

require_once dirname ( __FILE__ ) . '/../model/UsersModel.php';

use app\model\UsersModel;
use app\utility\utility;

/**
 * 登録 コントローラー
 *
 */
class register extends controller
{
    private $name = 'register';
    private $datas = [
        'name' => '',
        'password' => '',
        'confirm_password' => ''
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        session_start();
        
        Utility::setToken();

        $register = new register();
        $this->logging($register);

        return $this->view($this->name, [
            'name' => '',
            'password' => '',
            'confirm_password' => ''
        ]);
    }

    public function post()
    {

        session_start();
        
        // CSRF対策
        utility::checkToken();
        
        if(isset($_POST['add']))
        {

            // POSTデータ取得
            foreach($this->datas as $key => $tmp)
            {
                $value = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
                $datas[$key] = $value;
                $this->logging($value);
            }

            // バリデーションチェック
            $errors = Utility::validation($datas);

            $usersModel = new UsersModel();
            
            // 同一ユーザー名があるかチェック
            if(empty($errors['name']))
            {
                $user = $usersModel->select($datas['name']);
                if (!empty($user)) {
                    $errors['name'] = 'このユーザー名は既に使われています。';
                }
            }
            
            // エラーがなければ新規登録
            if (empty($errors))
            {
                $usersModel->insert([
                    'name' => $datas['name'],
                    'password' => password_hash($datas['password'], PASSWORD_DEFAULT),
                ]);
                
                header("location: login");
                exit;
            }
            else {
                return $this->view($this->name, [
                    'name' => $datas['name'],
                    'password' => $datas['password'],
                    'confirm_password' => $datas['confirm_password'],
                    'errors' => $errors
                ]);
            }
        }
    }

    public function __toString():string
    {
        return $this->name;
    }
}
