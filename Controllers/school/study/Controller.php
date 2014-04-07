<?php
require_once('Controllers/school/BaseSchoolController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseSchoolController
{
    function post () {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('SchoolSchoolSubject');
        require_once('Helpers/json.php');

        $userSubject = new SchoolSchoolSubject();

        $userSubject->s_id = $_SESSION['school_auth']['s_id'];

        ObjectParser::parse($_POST, $userSubject);

        if (!empty($userSubject->error)) {
            echo arrayToJson(array('error' => $userSubject->error));
            exit;
        }

        $this->db->insert($userSubject, true)->execute();

        $lastId = $this->db->lastId();

        if ($lastId == 0) {
            $userSubject->error = array();
            $userSubject->error[] = array('name' => 'ss_id', 'message' => 'Предмет уже существует в Вашем списке');
            echo arrayToJson(array('error' => $userSubject->error));
            exit;
        } else {
            $_SESSION['cabinet_message'][] = 'Изменения сохранены';
        }

        echo arrayToJson(array('success' => '/school/study'));
        exit;
    }

    function assignSubjects($schoolSubjectForm) {
        Application::requireClass('SchoolSubject');
        $subject = new SchoolSubject();

        $subjects = $this->db->select("sss_id, {$schoolSubjectForm->table}.ss_id, sr_id, subject")
            ->from($schoolSubjectForm->table)
            ->leftJoin($subject->table, "ON {$subject->table}.ss_id = {$schoolSubjectForm->table}.ss_id")
            ->where('s_id = ' . $_SESSION['school_auth']['s_id'])
            ->fetch();

        $this->smarty->assign('subjects', $subjects);
    }

    function display () {
        $this->prepareSchoolCabinet();

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        Application::requireClass('SchoolSubjectForm');
        $userSubjectForm = new SchoolSubjectForm();

        $this->assignSubjects($userSubjectForm);

        $this->smarty->assign(
            'form',
            array(
                'model' => $userSubjectForm,
                'class' => 'SchoolSubject',
                'action' => '/school/study',
                'action_name' => 'Добавить',
                'label_width' => 4,
                'field_width' => 6,
                'help_width' => 12,
                'help_offset' => 4,
                'value' => $_SESSION['school_auth']
            )
        );

        $this->smarty->assign('h1', 'Обучение');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'school_study');

        parent::display();
    }
}