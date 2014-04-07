<?php
require_once('Controllers/school/BaseSchoolController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseSchoolController
{
    function changeEmailRequest($new_email) {
        Application::requireClass('ChangeEmailSchool');
        $changeEmail = new ChangeEmailSchool();
        $changeEmail->email = $new_email;
        $changeEmail->s_id = $_SESSION['school_auth']['s_id'];
        $changeEmail->code = md5($_SESSION['school_auth']['s_id'] . $_SESSION['school_auth']['email'] . $new_email . $GLOBALS['salt']);

        $this->db->insert($changeEmail, true)->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('change_school_email');
        $email->SetValue('company', $_SESSION['school_auth']['school_name']);
        $email->SetValue('old_email', $_SESSION['school_auth']['email']);
        $email->SetValue('new_email', $new_email);
        $email->SetValue('code', $changeEmail->code);
        $email->Send($_SESSION['school_auth']['email'], 'Смена Email');

        $_SESSION['cabinet_message'][] = "Код с подтверждением для смены email на $new_email отправлен на адрес {$_SESSION['school_auth']['email']}";
    }

    function post() {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('BaseInfoSchool', 'School');
        require_once('Helpers/json.php');

        $user = new BaseInfoSchool();

        if (empty($_POST['password'])) {
            unset($user->password);
        }

        ObjectParser::parse($_POST, $user);

        $user->{$user->identity} = $_SESSION['school_auth']['s_id'];

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        if ($user->email != $_SESSION['school_auth']['email']) {
            $check_user = $this->db->select()->from($user->table)->where("email = '{$user->email}'")->fetch();

            if (!empty($check_user)) {
                $user->error[] = array ('name' => 'email', 'message' => ObjectParser::getMessage('unique'));
                echo arrayToJson(array('error' => $user->error));
                exit;
            }

            $this->changeEmailRequest($user->email);
            $user->email = $_SESSION['school_auth']['email'];
        }

        $this->db->update($user)->execute();

        ObjectParser::setSessionValues('school_auth', $user);

        $_SESSION['cabinet_message'][] = 'Изменения сохранены';

        echo arrayToJson(array('success' => '/school'));
        exit;
    }

    function assignSchoolType() {
        Application::requireClass('SchoolRubric');
        $schoolRubric = new SchoolRubric();

        $schoolRubric = $this->db->select('title')->from($schoolRubric->table)->where('sr_id = ' . $_SESSION['school_auth']['sr_id'])->fetch();

        if (!empty($schoolRubric)) {
            $this->smarty->assign('school', $schoolRubric[0]['title']);
        }
    }

    function display () {
        $this->prepareSchoolCabinet(false);

        $this->smarty->assign('h1', 'Общая информация');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'baseinfo');

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        if ($_SESSION['school_auth']['status'] == 0) {
            $this->smarty->assign('activation', 1);
        } else {
            $this->assignSchoolType();
        }

        Application::requireClass('BaseInfoSchool', 'School');
        $user = new BaseInfoSchool();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'class' => 'School',
                'action' => '/school',
                'action_name' => 'Сохранить',
                'label_width' => 2,
                'field_width' => 4,
                'help_width' => 6,
                'value' => $_SESSION['school_auth']
            )
        );

        parent::display();
    }
}