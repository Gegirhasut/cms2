<?php
require_once ('Controllers/admin/BaseAdminController.php');

class Controller extends BaseAdminController
{
    function post() {
        $login = $_POST['login'];
        $password = $_POST['password'];
        AdminSecurity::auth($login, $password);
    }

    function display () {
        if (AdminSecurity::isAdmin()) {
            parent::display();
        } else {
            $this->smarty->display('admin/login.tpl');
        }
    }
}