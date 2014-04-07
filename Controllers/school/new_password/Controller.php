<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function post () {
        require_once('Helpers/ObjectParser.php');
        Application::requireClass('NewPasswordUser', 'User');
        require_once('Helpers/json.php');

        $newPassword = new NewPasswordUser();

        ObjectParser::parse($_POST, $newPassword);

        if (!empty($newPassword->error)) {
            echo arrayToJson(array('error' => $newPassword->error));
            exit;
        }

        Application::requireClass('RemindPasswordSchool');
        $remindPassword = new RemindPasswordSchool();

        if (!isset($_SESSION['code'])) {
            if (isset($_GET['code'])) {
                $code = $this->db->escape($_GET['code']);
            } else {
                header ('location: /school/remind_password');
                exit;
            }
        } else {
            $code = $this->db->escape($_SESSION['code']);
        }

        $reminder = $this->db->select('s_id, rps_id')->from($remindPassword->table)->where("code = '$code'")->fetch();

        if (!empty($reminder)) {
            Application::requireClass('School');
            $user = new School();
            $user->s_id = $reminder[0]['s_id'];
            $user->password = $newPassword->password;
            $this->db->update($user)->execute();

            $_SESSION['cabinet_message'] = 'Пароль был изменен';

            $this->db->delete($remindPassword)->where("rps_id = {$reminder[0]['rps_id']}")->execute();

            echo arrayToJson(array('success' => '/school/login'));
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
                'action' => '/school/new_password',
                'action_name' => 'Изменить пароль',
                'label_width' => 2,
                'field_width' => 3,
                'help_width' => 7
            )
        );

        parent::display();
    }
}