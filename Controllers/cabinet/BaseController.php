<?php
require_once('Controllers/SmartyController.php');

class BaseController extends SmartyController
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

    function prepareCabinet($check_status = true) {
        if ($check_status && $_SESSION['user_auth']['status'] == 0) {
            header('location: /cabinet');
            exit;
        }

        Application::requireClass('User');
        $user = new User();
        $messages = $this->db->select('messages')->from($user->table)->where('u_id = ' . $_SESSION['user_auth']['u_id'])->fetch();

        if (empty($messages)) {
            $this->smarty->assign('messages_cnt', 0);
        } else {
            $this->smarty->assign('messages_cnt', $messages[0]['messages']);
        }
    }

    function display () {
        parent::display();
    }
}