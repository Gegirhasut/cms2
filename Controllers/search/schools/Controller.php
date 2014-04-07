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

        $url = '/schools';

        if (isset($_POST['r_id']) && !empty($_POST['r_id'])) {
            Application::requireClass('SchoolRubric');
            $rubric = new SchoolRubric();

            $rubrics = $this->db->select('r_url')
                ->from($rubric->table)
                ->where("sr_id = " . (int) $_POST['r_id'])
                ->fetch();

            if (empty($rubrics)) {
                if (!isset($_POST['city'])) {
                    echo arrayToJson(array('success' => '/schools'));
                    exit;
                }
            } else {
                $url .= '/' . strtolower($rubrics[0]['r_url']);
            }
        } elseif (!empty($_POST['country'])) {
            $url .= '/0';
        }

        if (isset($_POST['s_id']) && !empty($_POST['s_id'])) {
            Application::requireClass('SchoolSubject');
            $subject = new SchoolSubject();

            $subjects = $this->db->select('url')
                ->from($subject->table)
                ->where("ss_id = " . (int) $_POST['s_id'])
                ->fetch();

            if (empty($subjects)) {
                if (!isset($_POST['city'])) {
                    echo arrayToJson(array('success' => '/schools'));
                    exit;
                }
            } else {
                $url .= '/' . $subjects[0]['url'];
            }
        } elseif (!empty($_POST['country'])) {
            $url .= '/0';
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

        echo arrayToJson(array('success' => $url));
        exit;
    }

    function display () {
        $this->post();
    }
}