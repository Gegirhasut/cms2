<?php

class UserLogin {
    public static function loginById ($id, $register = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        require_once('Models/User.php');
        $user = new User();

        $user = $db->select('*')->from($user->table)->where($user->identity . " = $id")->fetch();

        if (!empty($user)) {
            if ($register) {
                if(!isset($_SESSION))
                {
                    session_start();
                }
                $_SESSION['user_auth'] = $user[0];
            }
            return $user[0];
        } else {
            return null;
        }
    }

    public static function loginByLogin ($email, $password, $register = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        require_once('Models/User.php');
        $user = new User();

        $user = $db->select('*')
            ->from($user->table)
            ->where("email = '$email' AND password = '$password'")
            ->fetch();

        if (!empty($user)) {
            if ($register) {
                if(!isset($_SESSION))
                {
                    session_start();
                }
                $_SESSION['user_auth'] = $user[0];
            }
            return $user[0];
        } else {
            return null;
        }
    }
}