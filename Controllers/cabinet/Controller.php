<?php
require_once('Controllers/cabinet/BaseController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseController
{
    function changeEmailRequest($new_email) {
        Application::requireClass('ChangeEmail');
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
        $email->SetValue('code', $changeEmail->code);
        $email->Send($_SESSION['user_auth']['email'], 'Смена Email');

        $_SESSION['cabinet_message'][] = "Код с подтверждением для смены email на $new_email отправлен на адрес {$_SESSION['user_auth']['email']}";
    }

    function post() {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('PersonalUser', 'User');
        require_once('Helpers/json.php');

        $user = new PersonalUser();

        if (empty($_POST['password'])) {
            unset($user->password);
        }

        ObjectParser::parse($_POST, $user);

        $user->{$user->identity} = $_SESSION['user_auth']['u_id'];

        if (!empty($user->error)) {
            echo arrayToJson(array('error' => $user->error));
            exit;
        }

        if ($user->email != $_SESSION['user_auth']['email']) {
            $check_user = $this->db->select()->from($user->table)->where("email = '{$user->email}'")->fetch();

            if (!empty($check_user)) {
                $user->error[] = array ('name' => 'email', 'message' => ObjectParser::getMessage('unique'));
                echo arrayToJson(array('error' => $user->error));
                exit;
            }

            $this->changeEmailRequest($user->email);
            $user->email = $_SESSION['user_auth']['email'];
        }

        $this->db->update($user)->execute();

        ObjectParser::setSessionValues('user_auth', $user);

        $_SESSION['cabinet_message'][] = 'Изменения сохранены';

        echo arrayToJson(array('success' => '/cabinet'));
        exit;
    }

    function assignCountry() {
        Application::requireClass('Country');
        $country = new Country();

        $country = $this->db->select('title')->from($country->table)->where('country_id = ' . $_SESSION['user_auth']['country'])->fetch();
        if (!empty($country)) {
            $this->smarty->assign('country', $country[0]['title']);
        }
    }

    function assignRegion() {
        Application::requireClass('Region');
        $region = new Region();

        $region = $this->db->select('title')->from($region->table)->where('region_id = ' . $_SESSION['user_auth']['region'])->fetch();

        if (!empty($region)) {
            $this->smarty->assign('region', $region[0]['title']);
        }
    }

    function assignCity() {
        Application::requireClass('City');
        $city = new City();

        $city = $this->db->select('title')->from($city->table)->where('city_id = ' . $_SESSION['user_auth']['city'])->fetch();

        if (!empty($city)) {
            $this->smarty->assign('city', $city[0]['title']);
        }
    }

    function display () {
        $this->prepareCabinet(false);

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

        Application::requireClass('PersonalUser', 'User');
        $user = new PersonalUser();
        $this->smarty->assign(
            'form',
            array(
                'model' => $user,
                'action' => '/cabinet',
                'action_name' => 'Сохранить',
                'label_width' => 1,
                'field_width' => 4,
                'help_width' => 7,
                'value' => $_SESSION['user_auth']
            )
        );

        parent::display();
    }
}