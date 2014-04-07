<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function post () {
        require_once('Helpers/ObjectParser.php');
        Application::requireClass('RemindPasswordSchool');
        require_once('Helpers/json.php');

        $remindPassword = new RemindPasswordSchool();

        ObjectParser::$object = 'Организация';
        ObjectParser::parse($_POST, $remindPassword);

        if (!empty($remindPassword->error)) {
            echo arrayToJson(array('error' => $remindPassword->error));
            exit;
        }

        Application::requireClass('School');
        $user = new School();
        $user = $this->db->select()->from($user->table)->where("email = '" . $this->db->escape($remindPassword->email) . "'")->fetch();

        if (!empty($user)) {
            $remindPassword->code = md5($user[0]['s_id'] . $user[0]['email'] . $GLOBALS['salt']);
            $remindPassword->s_id = $user[0]['s_id'];
            $this->db->insert($remindPassword, true)->execute();

            require_once('Helpers/Email.php');
            $email = new Email();

            $email->LoadTemplate('remind_password_school');
            $email->SetValue('company', $user[0]['school_name']);
            $email->SetValue('code', $remindPassword->code);
            $email->Send($user[0]['email'], 'Восстановление пароля');

            $_SESSION['cabinet_message'] = "На email {$user[0]['email']} выслана ссылка для востановления пароля!";

            echo arrayToJson(array('success' => ''));

        } else {
            $remindPassword->error[] = array('message' => ObjectParser::getMessage('email_not_found'), 'name' => 'email');
            echo arrayToJson(array('error' => $remindPassword->error));
        }

        exit;
    }

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function display () {
        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        $this->smarty->assign('h1', 'Восстановление пароля');
        $this->smarty->assign('page', 'remind_password');

        Application::requireClass('RemindPasswordUser', 'User');
        $user = new RemindPasswordUser();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'action' => '/school/remind_password',
                'action_name' => 'Восстановить',
                'label_width' => 1,
                'field_width' => 3,
                'help_width' => 8
            )
        );

        parent::display();
    }
}