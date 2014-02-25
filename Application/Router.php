<?php

class Router {
    public static $path = array();

    public static function getControllerPath () {
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