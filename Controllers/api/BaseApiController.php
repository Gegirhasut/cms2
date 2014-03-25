<?php

class BaseApiController {
    public function __construct () {
        if (!isset($_SESSION['user_auth'])) {
            header('location: /cabinet/login/');
            exit;
        }
    }
}