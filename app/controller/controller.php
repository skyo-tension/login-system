<?php
namespace app\controller;

require_once dirname ( __FILE__ ) . '/../../vendor/autoload.php';
require_once dirname ( __FILE__ ) . '/../utility/utility.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Smarty;
use app\utility\utility;

/**
 * ベース コントローラー
 *
 */
abstract class controller
{
    private $name = 'controller';

    public function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
    }

    public function __toString():string
    {
        return $this->name;
    }

    /**
     * ロギング
     * @param string $message
     * @param string $fileName
     */
    public function logging($message, string $fileName = 'app.log')
    {
        $Logger = new Logger('logger');
        $Logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/' . $fileName, Logger::INFO));
        $Logger->addInfo($message);
    }

    /**
     * ビルド テンプレート
     * @param string $template
     * @param array  $param
     * @return string
     */
    public function view(string $template, array $param): string
    {

        header_register_callback(function(){
            header_remove('X-Powered-By');
            header("X-FRAME-OPTIONS: DENY");
        });

        $Smarty = new Smarty();
        $Smarty->template_dir = __DIR__ . '/../view/';
        $Smarty->compile_dir  = __DIR__ . '/../view/view_c/';
        $Smarty->config_dir   = __DIR__ . '/../view/config/';
        $Smarty->escape_html  = false;
        $Smarty->assign([
            'cssUnCache'    => Utility::cssUnCache(),
            'url'           => Utility::getUrl(),
            'baseUrl'       => Utility::getBaseUrl(),
        ]);
        $Smarty->assign($param);
        return $Smarty->fetch($template . '.tpl');
    }

}
