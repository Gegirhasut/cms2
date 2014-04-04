<?php

class UserLogin {
    public static $mainClass = 'User';
    public static $session_name = 'user_auth';

    public static function loginById ($id, $register_in_session = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        Application::requireClass(self::$mainClass);
        $user = new self::$mainClass();

        $users = $db->select('*')->from($user->table)->where($user->identity . " = $id")->fetch();

        if (!empty($users)) {
            if ($register_in_session) {
                $_SESSION[self::$session_name] = $users[0];
            }
            if (isset($user->last_login)) {
                $db->sql("UPDATE {$user->table} SET last_login = CURRENT_TIMESTAMP WHERE {$user->identity} = $id");
            }

            $_SESSION[self::$session_name]['class'] = self::$mainClass;
            return $_SESSION[self::$session_name];
        } else {
            return null;
        }
    }

    public static function loginByLogin ($email, $password, $register_in_session = false) {
        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        Application::requireClass(self::$mainClass);
        $user = new self::$mainClass();

        $users = $db->select('*')
            ->from($user->table)
            ->where("email = '$email' AND password = '$password'")
            ->fetch();

        if (!empty($users)) {
            if ($register_in_session) {
                $_SESSION[self::$session_name] = $users[0];
            }
            if (isset($user->last_login)) {
                $db->sql("UPDATE {$user->table} SET last_login = CURRENT_TIMESTAMP WHERE {$user->identity} = " . $users[0][$user->identity]);
            }

            $_SESSION[self::$session_name]['class'] = self::$mainClass;
            return $_SESSION[self::$session_name];
        } else {
            return null;
        }
    }
}