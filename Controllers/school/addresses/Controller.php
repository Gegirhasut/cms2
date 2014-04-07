<?php
require_once('Controllers/school/BaseSchoolController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseSchoolController
{
    function post () {
        $_SESSION['cabinet_message'] = array();

        require_once('Helpers/ObjectParser.php');
        Application::requireClass('SchoolAddress');
        require_once('Helpers/json.php');

        $schoolAddress = new SchoolAddress();

        $schoolAddress->s_id = $_SESSION['school_auth']['s_id'];

        ObjectParser::parse($_POST, $schoolAddress);

        if (!empty($schoolAddress->error)) {
            echo arrayToJson(array('error' => $schoolAddress->error));
            exit;
        }

        $this->db->insert($schoolAddress)->execute();

        $this->db->lastId();

        $_SESSION['cabinet_message'][] = 'Изменения сохранены';

        echo arrayToJson(array('success' => '/school/addresses'));
        exit;
    }

    function assignAddresses() {
        Application::requireClass('SchoolAddress');
        $address = new SchoolAddress();
        Application::requireClass('Country');
        Application::requireClass('Region');
        Application::requireClass('City');
        $country = new Country();
        $region = new Region();
        $city = new City();

        $addresses = $this->db->select("sa_id, s_id, phones, emails, {$country->table}.title as country, {$region->table}.title as region, {$city->table}.title as city, street, latitude, longitude")
            ->from($address->table)
            ->join($country->table, "ON {$country->table}.country_id = {$address->table}.country")
            ->join($region->table, "ON {$region->table}.region_id = {$address->table}.region")
            ->join($city->table, "ON {$city->table}.city_id = {$address->table}.city")
            ->where('s_id = ' . $_SESSION['school_auth']['s_id'])
            ->fetch();

        $this->smarty->assign('addresses', $addresses);
    }

    function display () {
        $this->prepareSchoolCabinet();

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        Application::requireClass('SchoolAddressForm');
        $schoolAdressForm = new SchoolAddressForm();

        $this->assignAddresses();

        $this->smarty->assign(
            'form',
            array(
                'model' => $schoolAdressForm,
                'class' => 'SchoolAddress',
                'action' => '/school/addresses',
                'id' => 'form_btn_add_address',
                'action_name' => 'Добавить адрес',
                'label_width' => 3,
                'field_width' => 9,
                'help_width' => 12,
                'help_offset' => 3,
                'value' => $_SESSION['school_auth']
            )
        );

        $this->smarty->assign('map_field', $schoolAdressForm->fields['map']);

        $this->smarty->assign('h1', 'Адреса организации');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'school_addresses');

        parent::display();
    }
}