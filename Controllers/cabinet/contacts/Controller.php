<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = true;
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function post() {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('ContactUser', 'User');
        require_once('Helpers/json.php');

        $user = new ContactUser();

        ObjectParser::parse($_POST, $user);

        $user->{$user->identity} = $_SESSION['user_auth']['u_id'];

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        $this->db->update($user)->execute();

        ObjectParser::setSessionValues('user_auth', $user);

        $_SESSION['cabinet_message'][] = 'Изменения сохранены';

        echo arrayToJson(array('success' => '/cabinet/contacts'));
        exit;
    }

    function display () {
        if ($_SESSION['user_auth']['status'] == 0) {
            header('location: /cabinet');
            exit;
        }

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        Application::requireClass('ContactUser', 'User');
        $user = new ContactUser();

        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'class' => 'User',
                'action' => '/cabinet/contacts',
                'action_name' => 'Сохранить',
                'label_width' => 3,
                'field_width' => 4,
                'help_width' => 5,
                'value' => $_SESSION['user_auth']
            )
        );

        $this->smarty->assign('h1', 'Контактная информация');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'contacts');

        parent::display();
    }
}