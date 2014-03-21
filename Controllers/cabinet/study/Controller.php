<?php
require_once('Controllers/cabinet/BaseController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseController
{
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

        if ($lastId == 0) {
            $userSubject->error = array();
            $userSubject->error[] = array('name' => 's_id', 'message' => 'Предмет уже существует в Вашем списке');
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
        $this->prepareCabinet();

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
                'help_width' => 12,
                'help_offset' => 4,
                'value' => $_SESSION['user_auth']
            )
        );

        $this->smarty->assign('h1', 'Обучение');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'study');

        parent::display();
    }
}