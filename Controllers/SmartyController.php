<?php
class SmartyController
{
    protected $smarty = null;
    public $user_auth = false;

    function __construct () {
        if (!isset($_SESSION['source'])) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $_SESSION['source'] = $_SERVER['HTTP_REFERER'];
            } else {
                $_SESSION['source'] = 'direct';
            }
        }

        if ($this->user_auth && !isset($_SESSION['user_auth'])) {
            header('location: /auth/login');
            exit;
        }

        require_once('Application/SmartyLoader.php');
        $this->smarty = SmartyLoader::getSmarty();
        $this->smarty->caching = false;
        if (isset($_SESSION['user_auth'])) {
            $this->smarty->assign('user_auth', $_SESSION['user_auth']);
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