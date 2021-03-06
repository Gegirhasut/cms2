<?php
require_once ('Database/DBFactory.php');
Application::requireClass('ChangeEmail');

class Controller
{
    function display () {
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        $changeEmail = new ChangeEmail();

        $new_email = $db->select('ce_id, u_id, email')->from($changeEmail->table)->where("code = '" . $db->escape($_GET['code']) . "'")->fetch();

        if (!empty($new_email)) {
            Application::requireClass('User');
            $user = new User();
            $user->u_id = $new_email[0]['u_id'];
            $user->email = $new_email[0]['email'];
            $db->update($user)->execute();

            require_once('Application/UserLogin.php');
            UserLogin::loginById($new_email[0]['u_id'], true);

            $db->delete($changeEmail)->where($changeEmail->identity . ' = ' . $new_email[0]['ce_id'])->execute();

            $_SESSION['cabinet_message'] = array("Ваш основной email изменен!");
        }

        header('location: /cabinet');
        exit;
    }
}