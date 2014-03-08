<?php
class SmartyController
{
    protected $smarty = null;
    public $user_auth = false;

    function __construct () {
        if(!isset($_SESSION))
        {
            session_start();
        }

        if ($this->user_auth && !isset($_SESSION['user_auth'])) {
            header('location: /login');
            exit;
        }

        require_once('Application/SmartyLoader.php');
        $this->smarty = SmartyLoader::getSmarty();
        $this->smarty->caching = false;
        if (isset($_SESSION['user_auth'])) {
            $this->smarty->assign('user_auth', $_SESSION['user_auth']);
        }
    }

    function display () {
        $this->smarty->display('template.tpl');
    }
}