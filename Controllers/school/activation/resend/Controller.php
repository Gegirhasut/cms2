<?php
require_once ('Database/DBFactory.php');
Application::requireClass('SchoolActivation');

class Controller
{
    function display () {
        if (!isset($_SESSION['school_auth'])) {
            header('location: /school/login');
            exit;
        }

        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $activation = new SchoolActivation();

        $activation = $db->select('code')->from($activation->table)->where("s_id = '{$_SESSION['school_auth']['s_id']}'")->fetch();

        if (!empty($activation)) {
            if (!isset($_SESSION['activation_school_resend_email_sended'])) {
                require_once('Helpers/Email.php');
                $email = new Email();

                $email->LoadTemplate('activation_school_resend');
                $email->SetValue('company', $_SESSION['school_auth']['school_name']);
                $email->SetValue('code', $activation[0]['code']);
                $email->Send($_SESSION['school_auth']['email'], 'Активация личного кабинета организации');

                $_SESSION['activation_school_resend_email_sended'] = 1;
            }
            $_SESSION['cabinet_message'] = array("Ссылка для активации была отправлена на email {$_SESSION['school_auth']['email']}!");
        } else {
            $_SESSION['cabinet_message'] = array("Ссылка для активации была отправлена на email {$_SESSION['school_auth']['email']}!");
        }

        header('location: /school');
        exit;
    }
}