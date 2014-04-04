<?php

class BaseApiController {
    public function __construct () {
        $session_name = 'user_auth';
        $redirect_url = '/cabinet/login/';

        if (count(Router::$path) > 0) {
            $class = Router::$path[0];
            Application::requireClass($class);
            $object = new $class();

            if (isset($object->images['session_name'])) {
                $session_name = $object->images['session_name'];
            }

            if (isset($object->images['redirect_url'])) {
                $redirect_url = $object->images['redirect_url'];
            }
        }

        if (!isset($_SESSION[$session_name])) {
            header('location: ' . $redirect_url);
            exit;
        }
    }
}