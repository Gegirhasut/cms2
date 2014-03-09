<?php
require_once('Router.php');

class Application
{
    public static function requireClass($class, $fullClass = null) {
        if (file_exists('Models/' . $class . '.php')) {
            require_once('Models/' . $class . '.php');
            return true;
        }

        if (is_null($fullClass)) {
            $fullClass = $class;
        }

        if (file_exists("Models/$fullClass/" . $class . '.php')) {
            require_once("Models/$fullClass/" . $class . '.php');
            return true;
        }

        return false;
    }

    public static function run () {
        $controllerPath = Router::getControllerPath();
        require_once('Configs/Config.php');

        require_once($controllerPath . '/Controller.php');
        $controller = new ReflectionClass('Controller');
        $c = $controller->newInstance();

        if (!empty($_POST)) {
            $c->post();
        }
        $c->display();
    }
}