<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function loadSchool($user_id) {
        Application::requireClass('School');
        $user = new School();
        Application::requireClass('SchoolRubric');
        $rubric = new SchoolRubric();

        $users = $this->db
            ->select("{$rubric->table}.title, {$user->table}.school_name, {$user->table}.banner, {$user->table}.info, {$user->table}.website, {$user->table}.email, {$user->table}.s_id")
            ->from($user->table)
            ->join($rubric->table, "ON {$rubric->table}.sr_id = {$user->table}.sr_id")
            ->where($user->identity . " = $user_id AND status = 1")
            ->fetch();

        if (empty($users)) {
            throw new Exception404();
        }

        $this->smarty->assign('school', $users[0]);

        $this->smarty->assign('small_path', $user->images['small_path']);

        return $users[0];
    }

    function loadSubjects($user_id) {
        Application::requireClass('SchoolSubject');
        $subject = new SchoolSubject();
        Application::requireClass('SchoolSchoolSubject');
        $userSubject = new SchoolSchoolSubject();

        $subjects = $this->db
            ->select()
            ->from($userSubject->table)
            ->join($subject->table, "ON {$subject->table}.ss_id = {$userSubject->table}.ss_id")
            ->where("{$userSubject->table}.s_id = " . $user_id)->fetch();

        $this->smarty->assign('subjects', $subjects);

        return $subjects;
    }

    function assignAddresses($school_id) {
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
            ->where('s_id = ' . $school_id)
            ->fetch();

        $this->smarty->assign('addresses', $addresses);
    }

    function display () {
        if (!isset(Router::$path[0])) {
            throw new Exception404();
        }

        $user_id = (int) Router::$path[0];
        $user = $this->loadSchool($user_id);
        $subjects = $this->loadSubjects($user_id);
        $this->assignAddresses($user_id);

        $this->smarty->assign('h1', $user['title'] . ' - ' . $user['school_name']);
        $this->smarty->assign('no_operations', 1);

        $description_subjects = '';
        $keywords_subjects = '';
        $s_id = 0;
        foreach ($subjects as $subject) {
            $s_id++;
            $description_subjects .= empty($description_subjects) ? $subject['subject'] : ', ' . $subject['subject'];
            if ($s_id < 4) {
                $keywords_subjects .= empty($keywords_subjects) ? $subject['subject'] : ', ' . $subject['subject'];
            }
        }

        if (!empty($description_subjects)) {
            $description_subjects = ' Направления обучения: ' . $description_subjects . '.';
        }
        if (!empty($keywords_subjects)) {
            $keywords_subjects = ', ' . $keywords_subjects;
        }

        $this->smarty->assign('title', $user['title'] . ' - ' . $user['school_name']);
        $this->smarty->assign('description', $user['title'] . ' - ' . $user['school_name'] . '.' . $description_subjects);
        $this->smarty->assign('keywords', $user['title'] . ', ' . $user['school_name'] . $keywords_subjects);

        $this->smarty->assign('page', 'organization');

        parent::display();
    }
}