<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function post () {
        require_once('Helpers/ObjectParser.php');
        Application::requireClass('NewPassword');
        require_once('Helpers/json.php');

        $newPassword = new NewPassword();

        ObjectParser::parse($_POST, $newPassword);

        if (!empty($newPassword->error)) {
            echo arrayToJson(array('error' => $newPassword->error));
            exit;
        }

        Application::requireClass('RemindPassword');
        $remindPassword = new RemindPassword();

        if (!isset($_SESSION['code'])) {
            if (isset($_GET['code'])) {
                $code = $this->db->escape($_GET['code']);
            } else {
                header ('location: /auth/remind_password');
                exit;
            }
        } else {
            $code = $this->db->escape($_SESSION['code']);
        }

        $reminder = $this->db->select('u_id, rp_id')->from($remindPassword->table)->where("code = '$code'")->fetch();

        if (!empty($reminder)) {
            Application::requireClass('User');
            $user = new User();
            $user->u_id = $reminder[0]['u_id'];
            $user->password = $newPassword->password;
            $this->db->update($user)->execute();

            $_SESSION['cabinet_message'] = 'Пароль был изменен';

            $this->db->delete($remindPassword)->where("rp_id = {$reminder[0]['rp_id']}")->execute();

            echo arrayToJson(array('success' => '/auth/login'));
            exit;
        }

        echo arrayToJson(array('success' => ''));

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
        if (isset($_GET['code'])) {
            $_SESSION['code'] = $_GET['code'];
        }
        $this->smarty->assign('h1', 'Восстановление пароля');
        $this->smarty->assign('page', 'new_password');

        Application::requireClass('NewPasswordUser', 'User');
        $user = new NewPasswordUser();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'action' => '/auth/new_password',
                'action_name' => 'Изменить пароль',
                'label_width' => 2,
                'field_width' => 3,
                'help_width' => 7
            )
        );

        parent::display();
    }
}