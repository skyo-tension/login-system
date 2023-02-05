<?php
namespace app\utility;

final class Utility{

    protected function __construct(){

    }

    /**
     * ini file read
     * @param  string $key
     * @param  string $sub_key
     * @return string
     */
    public static function getIniValue(string $key, string $sub_key = null): string{
        $array_ini_file = parse_ini_file(__DIR__ . "/../app.ini", true);
        $value = $array_ini_file[$key];
        if(is_array($value) && !empty($sub_key)){
            $value = $value[$sub_key];
        }
        return $value;
    }

    /**
     * usage <link rel="stylesheet" href="css/style.css?<?=Utility::cssUnCache()?>">
     * @param  bool
     * @return string
     */
    public static function cssUnCache(bool $localhostOnly=true): string
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist) && $localhostOnly){
            return '?'.date('YmdHis');
        }else{
            return '';
        }
    }

    /**
     * getUrl
     * @return string
     */
    public static function getUrl(): string{
        $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        return $url;
    }

    /**
     * getBaseUrl
     * @return string
     */
    public static function getBaseUrl(): string{
        $array_parse_uri = explode('/', $_SERVER['REQUEST_URI']);
        $last_uri        = end($array_parse_uri);
        $parse_uri       = str_replace($last_uri, '', $_SERVER['REQUEST_URI']);
        $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$parse_uri;
        return $url;
    }

    /**
     * セッションにトークンセット
     * 
     * @return void
     */
    public static function setToken(): void{
        $token = sha1(uniqid(mt_rand(), true));
        $_SESSION['token'] = $token;
    }
    
    /**
     * セッション変数のトークンとPOSTされたトークンをチェック
     * 
     * @return void
     */
    public static function checkToken(): void{
        if(empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])){
            echo 'Invalid POST', PHP_EOL;
            exit;
        }
    }

    /**
     * バリデーション
     * 
     * @param array $datas
     * @param bool $confirm
     * @return array
     */
    public static function validation($datas, $confirm = true): array{
        $errors = [];

        //ユーザー名のチェック
        if(empty($datas['name'])) {
            $errors['name'] = 'Please enter username.';
        }else if(mb_strlen($datas['name']) > 20) {
            $errors['name'] = 'Please enter up to 20 characters.';
        }

        //パスワードのチェック（正規表現）
        if(empty($datas["password"])){
            $errors['password']  = "Please enter a password.";
        }else if(!preg_match('/\A[a-z\d]{8,100}+\z/i',$datas["password"])){
            $errors['password'] = "Please set a password with at least 8 characters.";
        }
        //パスワード入力確認チェック（ユーザー新規登録時のみ使用）
        if($confirm){
            if(empty($datas["confirm_password"])){
                $errors['confirm_password']  = "Please confirm password.";
            }else if(empty($errors['password']) && ($datas["password"] != $datas["confirm_password"])){
                $errors['confirm_password'] = "Password did not match.";
            }
        }

        return $errors;
    }
}
