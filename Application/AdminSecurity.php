<?php
class AdminSecurity
{
    protected static $admin_path = 'admin';

    public static function auth ($login, $password) {
        require_once('Configs/Admin.php');
        if ($login == $GLOBALS['admin']['login'] && $password == $GLOBALS['admin']['password']) {
            $_SESSION['admin_auth'] = 1;
        }
    }

    public static function logout() {
        session_start();
        unset($_SESSION['admin_auth']);
        header('location: /' . self::$admin_path . '/');
        exit;
    }

    public static function isAdmin() {
        return isset($_SESSION['admin_auth']);
    }

    public static function checkAdmin() {
        if (!isset($_SESSION['admin_auth'])) {
            if ($_SERVER['REDIRECT_URL'] != '/admin/') {
                header('location: /' . self::$admin_path . '/');
                exit;
            }
        }
    }
}