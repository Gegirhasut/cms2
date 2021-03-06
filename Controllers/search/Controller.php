<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = false;
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function post () {
        require_once('Helpers/json.php');

        $url = '/teachers';

        if (isset($_POST['s_id']) && !empty($_POST['s_id'])) {
            Application::requireClass('Subject');
            $subject = new Subject();

            $subjects = $this->db->select('url')
                ->from($subject->table)
                ->where("s_id = " . (int) $_POST['s_id'])
                ->fetch();

            if (empty($subjects)) {
                if (!isset($_POST['city'])) {
                    echo arrayToJson(array('success' => '/teachers'));
                    exit;
                }
            } else {
                $url .= '/' . $subjects[0]['url'];
            }
        }

        if (isset($_POST['country']) && $_POST['country'] != 0) {
            $url .= '/' . (int) $_POST['country'];
        }

        if (isset($_POST['region']) && $_POST['region'] != 0) {
            $url .= '/' . (int) $_POST['region'];
        }

        if (isset($_POST['city']) && $_POST['city'] != 0) {
            $url .= '/' . (int) $_POST['city'];
        }

        if (isset($_POST['from'])) {
            if (!isset($_SESSION['search'])) {
                $_SESSION['search'] = array();
            }

            $_SESSION['search']['from'] = (int) $_POST['from'];
        }

        if (isset($_POST['to'])) {
            if (!isset($_SESSION['search'])) {
                $_SESSION['search'] = array();
            }

            $_SESSION['search']['to'] = (int) $_POST['to'];
        }

        echo arrayToJson(array('success' => $url));
        exit;
    }

    function display () {
        $this->post();
    }
}