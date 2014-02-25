<?php

class Controller
{
    function display () {
        require_once('Application/AdminSecurity.php');
        AdminSecurity::logout();
    }
}