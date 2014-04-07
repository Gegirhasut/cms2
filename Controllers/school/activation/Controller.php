<?php
require_once ('Database/DBFactory.php');
Application::requireClass('SchoolActivation');

class Controller
{
    function display () {
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $activation = new SchoolActivation();
        $code = $db->escape($_GET['code']);

        $activations = $db->select('sa_id, s_id')->from($activation->table)->where("code = '$code'")->fetch();

        if (!empty($activations)) {
            Application::requireClass('School');
            $user = new School();
            $user->s_id = $activations[0]['s_id'];
            $user->status = 1;
            $db->update($user)->execute();

            require_once('Application/UserLogin.php');
            UserLogin::$mainClass = 'School';
            UserLogin::$session_name = 'school_auth';
            $user = UserLogin::loginById($activations[0]['s_id'], true);

            if (!is_null($user)) {
                $db->delete($activation)->where("code = '$code'")->execute();
                header('location: /school');
            } else {
                header('location: /');
            }
        } else {
            header('location: /');
        }

        exit;
    }
}