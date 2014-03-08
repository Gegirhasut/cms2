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

    function changeEmailRequest($new_email) {
        require_once('Models/ChangeEmail.php');
        $changeEmail = new ChangeEmail();
        $changeEmail->email = $new_email;
        $changeEmail->u_id = $_SESSION['user_auth']['u_id'];
        $changeEmail->code = md5($_SESSION['user_auth']['u_id'] . $_SESSION['user_auth']['email'] . $new_email . $GLOBALS['salt']);

        $this->db->insert($changeEmail, true)->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('change_email');
        $email->SetValue('fio', $_SESSION['user_auth']['fio']);
        $email->SetValue('old_email', $_SESSION['user_auth']['email']);
        $email->SetValue('new_email', $new_email);
        $email->SetValue('url', 'http://' . $_SERVER['SERVER_NAME']);
        $email->SetValue('code', $changeEmail->code);
        $email->Send($_SESSION['user_auth']['email'], 'Смена Email');

        $_SESSION['cabinet_message'][] = "Код с подтверждением для смены email на $new_email отправлен на адрес {$_SESSION['user_auth']['email']}";
    }

    function post() {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        require_once('Models/User.php');
        require_once('Helpers/json.php');

        $user = new User();
        unset($user->password2);

        if (empty($_POST['password'])) {
            unset($user->password);
        }

        ObjectParser::parse($_POST, $user);

        $user->{$user->identity} = $_SESSION['user_auth']['u_id'];
        unset($user->status);

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        if ($user->email != $_SESSION['user_auth']['email']) {
            $this->changeEmailRequest($user->email);
            $user->email = $_SESSION['user_auth']['email'];
        }

        $this->db->update($user)->execute();

        ObjectParser::setSessionValues('user_auth', $user);

        $_SESSION['cabinet_message'][] = 'Изменения сохранены';

        echo 'success';
        exit;
    }


    function assignCountry() {
        require_once('Models/Country.php');
        $country = new Country();

        $country = $this->db->select('title')->from($country->table)->where('country_id = ' . $_SESSION['user_auth']['country'])->fetch();
        if (!empty($country)) {
            $this->smarty->assign('country', $country[0]['title']);
        }
    }

    function assignRegion() {
        require_once('Models/Region.php');
        $region = new Region();

        $region = $this->db->select('title')->from($region->table)->where('region_id = ' . $_SESSION['user_auth']['region'])->fetch();

        if (!empty($region)) {
            $this->smarty->assign('region', $region[0]['title']);
        }
    }

    function assignCity() {
        require_once('Models/City.php');
        $city = new City();

        $city = $this->db->select('title')->from($city->table)->where('city_id = ' . $_SESSION['user_auth']['city'])->fetch();

        if (!empty($city)) {
            $this->smarty->assign('city', $city[0]['title']);
        }
    }

    function display () {
        $this->smarty->assign('h1', 'Персональные данные');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'personal');

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        if ($_SESSION['user_auth']['status'] == 0) {
            $this->smarty->assign('activation', 1);
        } else {
            $this->assignCountry();
            $this->assignRegion();
            $this->assignCity();
        }

        parent::display();
    }
}