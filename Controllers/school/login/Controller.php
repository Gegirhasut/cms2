<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    function post () {
        require_once('Helpers/ObjectParser.php');
        Application::requireClass('LoginSchool', 'School');
        require_once('Helpers/json.php');

        $user = new LoginSchool();

        ObjectParser::parse($_POST, $user);

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        require_once('Application/UserLogin.php');
        UserLogin::$mainClass = 'School';
        UserLogin::$session_name = 'school_auth';
        $user = UserLogin::loginByLogin($db->escape($user->email), $db->escape($user->password), true);

        if (!is_null($user)) {
            echo arrayToJson(array('success' => '/school'));
        } else {
            $user->error[] = array('name' => 'email', 'message' => ObjectParser::getMessage('login'));
            echo arrayToJson(array('error' => $user->error));
        }

        exit;
    }

    function display () {
        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        Application::requireClass('LoginSchool', 'School');
        $user = new LoginSchool();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'action' => '/school/login',
                'action_name' => 'Войти',
                'label_width' => 1,
                'field_width' => 3,
                'help_width' => 8
            )
        );

        $this->smarty->assign('page', 'login_school');
        parent::display();
    }
}