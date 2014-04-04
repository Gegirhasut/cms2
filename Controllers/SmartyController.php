<?php
class SmartyController
{
    protected $smarty = null;
    public $user_auth = false;
    public static $user_auth_name = 'user_auth';
    public static $access_denied_redirect = '/auth/login';

    function __construct () {
        if (!isset($_SESSION['source'])) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $_SESSION['source'] = $_SERVER['HTTP_REFERER'];
            } else {
                $_SESSION['source'] = 'direct';
            }
        }

        if ($this->user_auth && !isset($_SESSION[self::$user_auth_name])) {
            header('location: ' . self::$access_denied_redirect);
            exit;
        }

        require_once('Application/SmartyLoader.php');
        $this->smarty = SmartyLoader::getSmarty();
        $this->smarty->caching = false;
        if (isset($_SESSION[self::$user_auth_name])) {
            $this->smarty->assign('user_auth', $_SESSION[self::$user_auth_name]);
        }
    }

    function display ($cache = false) {
        if ($cache) {
            return $this->smarty->fetch('template.tpl');
        } else {
            $this->smarty->display('template.tpl');
        }
    }
}