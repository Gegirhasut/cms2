<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    function post () {
        require_once('Helpers/ObjectParser.php');
        Application::requireClass('RegistrationSchool', 'School');
        require_once('Helpers/json.php');

        $user = new RegistrationSchool();

        ObjectParser::$object = 'Организация';
        ObjectParser::parse($_POST, $user);

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $users = $db->select('count(*) as cnt')->from($user->table)->where("email = '" . $db->escape($user->email) . "'")->fetch();

        if ($users[0]['cnt'] > 0) {
            echo arrayToJson(array('error' => array(0 => array ('name' => 'email', 'message' => ObjectParser::getMessage('unique')))));
            exit;
        }

        Application::requireClass('RegSource');
        $regSource = new RegSource();
        $regSource->source = substr($_SESSION['source'], 0, 1000);
        $regSource->source_md5 = md5($_SESSION['source']);
        $db->insert($regSource)->onduplicate($regSource, array('cnt' => 1))->execute();
        $source_id = $db->lastId();
        $user->source_id = $source_id;

        $db->insert($user)->execute();
        $s_id = $db->lastId();
        require_once('Application/UserLogin.php');
        UserLogin::$mainClass = 'School';
        UserLogin::$session_name = 'school_auth';
        UserLogin::loginById($s_id, true);

        Application::requireClass('SchoolActivation');
        $activation = new SchoolActivation();
        $s_id = $db->lastId();
        $activation->s_id = $s_id;
        $activation->code = md5(time() . $s_id . $GLOBALS['salt']);

        $db->insert($activation)->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('register_for_school');
        $email->SetValue('company', $user->school_name);
        $email->SetValue('email', $user->email);
        $email->SetValue('password', $_POST['password']);
        $email->SetValue('code', $activation->code);
        $email->Send($user->email, 'Регистрация организации на сайте Все Учителя');

        $email->LoadTemplate('register_school_for_admin');
        $email->SetValue('company', $user->school_name);
        $email->SetValue('email', $user->email);
        $email->SetValue('password', $_POST['password']);
        $email->SetValue('ua', $this->getUserAgent());
        $email->SetValue('ip', $this->getIp());
        $email->Send($GLOBALS['admin'], 'Новая регистрация организации на сайте Все Учителя');

        echo arrayToJson(array('success' => '/school'));

        exit;
    }

    function getUserAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'undefined';
    }

    function getIp() {
        $ip = 'REMOTE_ADDR = ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        $ip .= '; HTTP_X_FORWARDED_FOR = ' . (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != 'unknown' ? ' FW: '.$_SERVER['HTTP_X_FORWARDED_FOR'] : '');
        $ip .= '; HTTP_CLIENT_IP = ' . (isset($_SERVER['HTTP_CLIENT_IP']) ? ' CLIENT_IP: '.$_SERVER['HTTP_CLIENT_IP'] : '');
        $ip .= '; HTTP_VIA = ' . (isset($_SERVER['HTTP_VIA']) ? ' VIA: '.$_SERVER['HTTP_VIA'] : '');

        return $ip;
    }

    function display () {
        Application::requireClass('RegistrationSchool', 'School');
        $user = new RegistrationSchool();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'action' => '/school/registration',
                'action_name' => 'Зарегистрировать',
                'label_width' => 2,
                'field_width' => 4,
                'help_width' => 6
            )
        );

        $this->smarty->assign('h1', 'Регистрация обучающего центра');
        $this->smarty->assign('page', 'registration');
        parent::display();
    }
}