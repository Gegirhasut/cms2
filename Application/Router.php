<?php

class Router {
    public static $path = array();

    public static function getControllerPath () {
        // Fix for NGINX
        if (!isset($_SERVER['REDIRECT_URL'])) {
            $_SERVER['REDIRECT_URL'] = $_SERVER['REQUEST_URI'];
            $pos = strpos($_SERVER['REDIRECT_URL'], '?');
            if ($pos !== false) {
                $_SERVER['REDIRECT_URL'] = substr($_SERVER['REDIRECT_URL'], 0, $pos);
            }
        }

        $path = 'Controllers' . rtrim($_SERVER['REDIRECT_URL'], '/');

        while (!is_dir($path)) {
            $pos = strrpos($path, '/');
            if ($pos === false) {
                return $path;
            }

            self::$path[] = substr($path, $pos + 1);

            $path = substr($path, 0, $pos);
        }

        return $path;
    }
}