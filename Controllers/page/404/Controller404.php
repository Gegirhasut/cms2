<?php
require_once('Controllers/SmartyController.php');

class Controller404 extends SmartyController
{
    public $user_auth = false;

    function display () {
        header('HTTP/1.0 404 Not Found');
        $this->smarty->assign('title', 'Страница не существует');
        $this->smarty->assign('description', 'Страница не существует');
        $this->smarty->assign('keywords', 'Страница не существует');

        $this->smarty->assign('page', '404');

        parent::display();
    }
}