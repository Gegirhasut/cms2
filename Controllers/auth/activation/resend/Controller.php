<?php
require_once ('Database/DBFactory.php');
Application::requireClass('Activation');

class Controller
{
    function display () {
        if (!isset($_SESSION['user_auth'])) {
            header('location: /auth/login');
            exit;
        }

        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $activation = new Activation();

        $activation = $db->select('code')->from($activation->table)->where("u_id = '{$_SESSION['user_auth']['u_id']}'")->fetch();

        if (!empty($activation)) {
            if (!isset($_SESSION['activation_resend_email_sended'])) {
                require_once('Helpers/Email.php');
                $email = new Email();

                $email->LoadTemplate('activation_resend');
                $email->SetValue('fio', $_SESSION['user_auth']['fio']);
                $email->SetValue('code', $activation[0]['code']);
                $email->Send($_SESSION['user_auth']['email'], 'Активация личного кабинета');

                $_SESSION['activation_resend_email_sended'] = 1;
            }
            $_SESSION['cabinet_message'] = array("Ссылка для активации была отправлена на email {$_SESSION['user_auth']['email']}!");
        } else {
            $_SESSION['cabinet_message'] = array("Ссылка для активации была отправлена на email {$_SESSION['user_auth']['email']}!");
        }

        header('location: /cabinet');
        exit;
    }
}