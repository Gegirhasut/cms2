<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function post () {
        require_once('Helpers/ObjectParser.php');
        require_once('Models/RemindPassword.php');
        require_once('Helpers/json.php');

        $remindPassword = new RemindPassword();

        ObjectParser::parse($_POST, $remindPassword);

        if (!empty($remindPassword->error)) {
            echo arrayToJson(array('error' => $remindPassword->error));
            exit;
        }

        require_once('Models/User.php');
        $user = new User();
        $user = $this->db->select()->from($user->table)->where("email = '" . $this->db->escape($remindPassword->email) . "'")->fetch();

        if (!empty($user)) {
            $remindPassword->code = md5($user[0]['u_id'] . $user[0]['email'] . $GLOBALS['salt']);
            $remindPassword->u_id = $user[0]['u_id'];
            $this->db->insert($remindPassword, true)->execute();

            require_once('Helpers/Email.php');
            $email = new Email();

            $email->LoadTemplate('remind_password');
            $email->SetValue('fio', $user[0]['fio']);
            $email->SetValue('url', 'http://' . $_SERVER['SERVER_NAME']);
            $email->SetValue('code', $remindPassword->code);
            $email->Send($user[0]['email'], 'Восстановление пароля');

            $_SESSION['cabinet_message'] = "На email {$user[0]['email']} выслана ссылка для востановления пароля!";

            echo arrayToJson(array('success' => ''));

        } else {
            $remindPassword->error[] = array('message' => 'not_found', 'name' => 'email');
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

        parent::display();
    }
}