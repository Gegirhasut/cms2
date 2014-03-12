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

    function post () {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('UserSubject');
        require_once('Helpers/json.php');

        $userSubject = new UserSubject();

        $userSubject->u_id = $_SESSION['user_auth']['u_id'];

        ObjectParser::parse($_POST, $userSubject);

        if (!empty($userSubject->error)) {
            echo arrayToJson(array('error' => $userSubject->error));
            exit;
        }

        $this->db->insert($userSubject, true)->execute();

        $lastId = $this->db->lastId();

        //echo $lastId;

        if ($lastId == 0) {
            $userSubject->error = array();
            $userSubject->error[] = array('name' => 's_id', 'message' => 'Предмет уже существует в Вашем списке');
            //print_r($userSubject->error);
            echo arrayToJson(array('error' => $userSubject->error));
            exit;
        } else {
            $_SESSION['cabinet_message'][] = 'Изменения сохранены';
        }

        echo arrayToJson(array('success' => '/cabinet/study'));
        exit;
    }

    function assignSubjects($userSubjectForm) {
        Application::requireClass('Subject');
        $subject = new Subject();

        $subjects = $this->db->select("us_id, {$userSubjectForm->table}.s_id, r_id, duration, cost, subject")
            ->from($userSubjectForm->table)
            ->leftJoin($subject->table, "ON {$subject->table}.s_id = {$userSubjectForm->table}.s_id")
            ->where('u_id = ' . $_SESSION['user_auth']['u_id'])
            ->fetch();

        $this->smarty->assign('subjects', $subjects);
    }

    function display () {
        if ($_SESSION['user_auth']['status'] == 0) {
            header('location: /cabinet');
            exit;
        }

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        Application::requireClass('UserSubjectForm');
        $userSubjectForm = new UserSubjectForm();

        $this->assignSubjects($userSubjectForm);

        $this->smarty->assign(
            'form',
            array(
                'model' => $userSubjectForm,
                'class' => 'UserSubject',
                'action' => '/cabinet/study',
                'action_name' => 'Добавить',
                'label_width' => 4,
                'field_width' => 6,
                'help_width' => 5,
                'value' => $_SESSION['user_auth']
            )
        );

        $this->smarty->assign('h1', 'Обучение');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'study');

        parent::display();
    }
}