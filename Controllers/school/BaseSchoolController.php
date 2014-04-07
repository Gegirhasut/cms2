<?php
require_once('Controllers/SmartyController.php');

class BaseSchoolController extends SmartyController
{
    public $user_auth = true;
    public $db = null;

    function __construct() {
        SmartyController::$user_auth_name = 'school_auth';
        SmartyController::$access_denied_redirect = '/school/login';
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
        $this->smarty->assign('menu', 'school');
    }

    function prepareSchoolCabinet($check_status = true) {
        if ($check_status && $_SESSION['school_auth']['status'] == 0) {
            header('location: /school');
            exit;
        }
    }

    function display () {
        parent::display();
    }
}