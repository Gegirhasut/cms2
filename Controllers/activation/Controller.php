<?php
require_once ('Database/DBFactory.php');
require_once('Models/Activation.php');

class Controller
{
    function display () {
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $activation = new Activation();
        $code = $db->escape($_GET['code']);

        $activations = $db->select('a_id, u_id')->from($activation->table)->where("code = '$code'")->fetch();

        if (!empty($activations)) {
            require_once('Models/User.php');
            $user = new User();
            $user->u_id = $activations[0]['u_id'];
            $user->status = 1;
            $db->update($user)->execute();

            require_once('Application/UserLogin.php');
            $user = UserLogin::loginById($activations[0]['u_id'], true);

            if (!is_null($user)) {
                $db->delete()->from($activation->table)->where("code = '$code'")->execute();
                header('location: /cabinet');
            } else {
                header('location: /');
            }
        } else {
            header('location: /');
        }

        exit;
    }
}