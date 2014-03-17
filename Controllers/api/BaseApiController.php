<?php

class BaseApiController {
    public function __construct () {
        session_start();

        if (!isset($_SESSION['user_auth'])) {
            header('location: /cabinet/login/');
            exit;
        }
    }
}