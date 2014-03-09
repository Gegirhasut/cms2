<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    function post () {
        require_once('Helpers/ObjectParser.php');
        require_once('Models/User.php');
        require_once('Helpers/json.php');

        $user = new User();

        ObjectParser::parse($_POST, $user);

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        require_once ('Database/DBFactory.php');
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $users = $db->select('count(*) as cnt')->from($user->table)->where("email = '" . $db->escape($user->email) . "'")->fetch();

        if ($users[0]['cnt'] > 0) {
            echo arrayToJson(array('error' => array(0 => array ('name' => 'email', 'message' => 'unique'))));
            exit;
        }

        $db->insert($user)->execute();
        $u_id = $db->lastId();
        require_once('Application/UserLogin.php');
        UserLogin::loginById($u_id, true);

        require_once('Models/Activation.php');
        $activation = new Activation();
        $u_id = $db->lastId();
        $activation->u_id = $u_id;
        $activation->code = md5(time() . $u_id . $GLOBALS['salt']);

        $db->insert($activation)->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('register_for_user');
        $email->SetValue('fio', $user->fio);
        $email->SetValue('email', $user->email);
        $email->SetValue('password', $user->password);
        $email->SetValue('url', 'http://' . $_SERVER['SERVER_NAME']);
        $email->SetValue('code', $activation->code);
        $email->Send($user->email, 'Регистрация на сайте Все Учителя');

        $email->LoadTemplate('register_for_admin');
        $email->SetValue('fio', $user->fio);
        $email->SetValue('email', $user->email);
        $email->SetValue('password', $user->password);
        $email->SetValue('url', 'http://' . $_SERVER['SERVER_NAME']);
        $email->Send($GLOBALS['admin'], 'Новая регистрация на сайте Все Учителя');

        echo arrayToJson(array('success' => '/cabinet'));

        exit;
    }

    function display () {
        $this->smarty->assign('page', 'registration');
        parent::display();
    }
}