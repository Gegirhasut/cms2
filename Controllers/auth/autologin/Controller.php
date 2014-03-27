<?php
require_once ('Database/DBFactory.php');
Application::requireClass('UserAutoLogin', 'User');

class Controller
{
    function display () {
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $userAL = new UserAutoLogin();
        $code = $db->escape($_GET['code']);

        $pages = $db->select('u_id, page')->from($userAL->table)->where("code = '$code'")->fetch();

        if (!empty($pages)) {
            require_once('Application/UserLogin.php');
            $user = UserLogin::loginById($pages[0]['u_id'], true);

            if (!is_null($user)) {
                switch ($pages[0]['page']) {
                    case 'messages':
                        header('location: /cabinet/messages');
                        exit;
                }
            }
        }

        header('location: /');
        exit;
    }
}