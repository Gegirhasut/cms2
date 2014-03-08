<?php
require_once('Router.php');

class Application
{
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