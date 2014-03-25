<?php

class UserLogin {
    public static function loginById ($id, $register_in_session = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        Application::requireClass('User');
        $user = new User();

        $users = $db->select('*')->from($user->table)->where($user->identity . " = $id")->fetch();

        if (!empty($users)) {
            if ($register_in_session) {
                $_SESSION['user_auth'] = $users[0];
            }
            $db->sql("UPDATE {$user->table} SET last_login = CURRENT_TIMESTAMP WHERE u_id = $id");

            return $_SESSION['user_auth'];
        } else {
            return null;
        }
    }

    public static function loginByLogin ($email, $password, $register_in_session = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        Application::requireClass('User');
        $user = new User();

        $users = $db->select('*')
            ->from($user->table)
            ->where("email = '$email' AND password = '$password'")
            ->fetch();

        if (!empty($users)) {
            if ($register_in_session) {
                $_SESSION['user_auth'] = $users[0];
            }
            $db->sql("UPDATE {$user->table} SET last_login = CURRENT_TIMESTAMP WHERE u_id = {$users[0]['u_id']}");

            return $_SESSION['user_auth'];
        } else {
            return null;
        }
    }
}