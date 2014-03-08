<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    function post () {
        require_once('Helpers/ObjectParser.php');
        require_once('Models/User.php');
        require_once('Helpers/json.php');

        $user = new User();

        ObjectParser::parse($_POST, $user, true);

        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        require_once('Application/UserLogin.php');
        $user = UserLogin::loginByLogin($db->escape($user->email), $db->escape($user->password), true);

        if (!is_null($user)) {
            echo 'success';
        } else {
            echo 'error';
        }

        exit;
    }

    function display () {
        $this->smarty->assign('page', 'login');
        parent::display();
    }
}