<?php
require_once ('Database/DBFactory.php');
Application::requireClass('ChangeEmailSchool');

class Controller
{
    function display () {
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $changeEmail = new ChangeEmailSchool();

        $new_email = $db->select('ces_id, s_id, email')->from($changeEmail->table)->where("code = '" . $db->escape($_GET['code']) . "'")->fetch();

        if (!empty($new_email)) {
            Application::requireClass('School');
            $user = new School();
            $user->s_id = $new_email[0]['s_id'];
            $user->email = $new_email[0]['email'];
            $db->update($user)->execute();

            require_once('Application/UserLogin.php');
            UserLogin::$mainClass = 'School';
            UserLogin::$session_name = 'school_auth';
            UserLogin::loginById($new_email[0]['s_id'], true);

            $db->delete($changeEmail)->where($changeEmail->identity . ' = ' . $new_email[0]['ces_id'])->execute();

            $_SESSION['cabinet_message'] = array("Ваш основной email изменен!");
        }

        header('location: /school');
        exit;
    }
}