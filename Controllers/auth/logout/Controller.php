<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function display () {
        if (isset($_SESSION['user_auth'])) {
            unset($_SESSION['user_auth']);
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('location: /');
        }
        exit;
    }
}