<?php
require_once('Application/AdminSecurity.php');
class BaseApiController {
    public function __construct () {
        session_start();

        AdminSecurity::checkAdmin();
    }
}