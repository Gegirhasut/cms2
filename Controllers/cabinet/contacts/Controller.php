<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = true;
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function display () {
        if ($_SESSION['user_auth']['status'] == 0) {
            header('location: /cabinet');
            exit;
        }

        $this->smarty->assign('h1', 'Контактная информация');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'contacts');

        parent::display();
    }
}