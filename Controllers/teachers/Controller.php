<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = false;
    public $db = null;
    public $page = 1;

    public $teachersLimit = 10;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function allTeachers () {
        $teachers = $this->getTeachers("status = 1");

        $this->smarty->assign('teachers', $teachers);

        $title = "Поиск учителя онлайн. Репетитора рядом с домом. Обучение по скайпу.";
        if ($this->page != 1) {
            $title .= ' Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя");
        $this->smarty->assign('description', "Поиск учителя онлайн. Найти репетитора рядом с домом. Обучение по скайп.");
        $this->smarty->assign('keywords', "репетиторы, учителя, обучение по скайп, онлайн обучение");
    }

    function subjectTeachersInCity ($pageUrl, $city_id) {
        $userSubject = new UserSubject();
        if ($pageUrl != '-') {
            $subjects = $this->getSubjects($pageUrl);
            $subject_po = $subjects[0]['subject_po'];
            $subject = $subjects[0]['subject'];
        }

        $this->smarty->assign('subject', $subjects[0]);

        Application::requireClass('City');
        $city = new City();
        Application::requireClass('Region');
        $region = new Region();
        Application::requireClass('Country');
        $country = new Country();

        $cities = $this->db
            ->select("{$city->table}.title as city, {$city->table}.city_id, {$region->table}.title as region, {$region->table}.region_id, {$country->table}.title as country, {$country->table}.country_id")
            ->from($city->table)
            ->join($region->table, "ON {$region->table}.{$region->identity} = {$city->table}.region_id")
            ->join($country->table, "ON {$country->table}.{$country->identity} = {$city->table}.country_id")
            ->where("city_id = $city_id")->fetch();

        if (empty($cities)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $cities[0]);

        $teachers = $this->getTeachersWithSubjects("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND city = $city_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя по $subject_po в городе " . $cities[0]['city'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя по $subject_po в городе " . $cities[0]['city']);
        $this->smarty->assign('description', "Учителя по $subject_po в городе {$cities[0]['city']}. Найти репетитора рядом с домом в городе {$cities[0]['city']}.");
        $this->smarty->assign('keywords', "учителя по $subject_po, {$cities[0]['city']}, репетиторы {$cities[0]['city']}, учителя {$cities[0]['city']}, $subject");
    }

    function subjectTeachersInRegion ($pageUrl, $region_id) {
        $userSubject = new UserSubject();
        if ($pageUrl != '-') {
            $subjects = $this->getSubjects($pageUrl);
            $subject_po = $subjects[0]['subject_po'];
            $subject = $subjects[0]['subject'];
        }

        $this->smarty->assign('subject', $subjects[0]);

        Application::requireClass('Region');
        $region = new Region();
        Application::requireClass('Country');
        $country = new Country();

        $regions = $this->db
            ->select("{$region->table}.title as region, {$region->table}.region_id, {$country->table}.title as country, {$country->table}.country_id")
            ->from($region->table)
            ->join($country->table, "ON {$country->table}.{$country->identity} = {$region->table}.country_id")
            ->where("region_id = $region_id")->fetch();

        if (empty($regions)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $regions[0]);

        $teachers = $this->getTeachersWithSubjects("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND region = $region_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя по $subject_po в городе " . $regions[0]['region'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя по $subject_po в " . $regions[0]['country'] . ', ' . $regions[0]['region']);
        $this->smarty->assign('description', "Учителя по $subject_po в {$regions[0]['country']}, {$regions[0]['region']}. Найти репетитора рядом с домом в {$regions[0]['country']}, {$regions[0]['region']}.");
        $this->smarty->assign('keywords', "учителя по $subject_po, {$regions[0]['country']} {$regions[0]['region']}, репетиторы {$regions[0]['region']}, учителя {$regions[0]['region']}, $subject {$regions[0]['region']}");
    }

    function subjectTeachersInCountry ($pageUrl, $country_id) {
        $userSubject = new UserSubject();
        if ($pageUrl != '-') {
            $subjects = $this->getSubjects($pageUrl);
            $subject_po = $subjects[0]['subject_po'];
            $subject = $subjects[0]['subject'];
        }

        $this->smarty->assign('subject', $subjects[0]);

        Application::requireClass('Country');
        $country = new Country();

        $countries = $this->db
            ->select("{$country->table}.title as country, {$country->table}.country_id")
            ->from($country->table)
            ->where("country_id = $country_id")->fetch();

        if (empty($countries)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $countries[0]);

        $teachers = $this->getTeachersWithSubjects("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND country = $country_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя по $subject_po в стране " . $countries[0]['country'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя по $subject_po в стране " . $countries[0]['country']);
        $this->smarty->assign('description', "Учителя по $subject_po в стране {$countries[0]['country']}. Найти репетитора в стране {$countries[0]['country']}.");
        $this->smarty->assign('keywords', "учителя по $subject_po, страна {$countries[0]['country']}, репетиторы {$countries[0]['country']}, учителя {$countries[0]['country']}, $subject {$countries[0]['country']}");
    }

    function teachersInCity ($city_id) {
        Application::requireClass('City');
        $city = new City();
        Application::requireClass('Region');
        $region = new Region();
        Application::requireClass('Country');
        $country = new Country();

        $cities = $this->db
            ->select("{$city->table}.title as city, {$city->table}.city_id, {$region->table}.title as region, {$region->table}.region_id, {$country->table}.title as country, {$country->table}.country_id")
            ->from($city->table)
            ->join($region->table, "ON {$region->table}.{$region->identity} = {$city->table}.region_id")
            ->join($country->table, "ON {$country->table}.{$country->identity} = {$city->table}.country_id")
            ->where("city_id = $city_id")->fetch();

        if (empty($cities)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $cities[0]);

        $teachers = $this->getTeachers("city = $city_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя в городе " . $cities[0]['city'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя в городе " . $cities[0]['city']);
        $this->smarty->assign('description', "Учителя в городе {$cities[0]['city']}. Найти репетитора рядом с домом в городе {$cities[0]['city']}.");
        $this->smarty->assign('keywords', "{$cities[0]['city']}, репетиторы {$cities[0]['city']}, учителя {$cities[0]['city']}");
    }

    function teachersInRegion ($region_id) {
        Application::requireClass('Region');
        $region = new Region();
        Application::requireClass('Country');
        $country = new Country();

        $regions = $this->db
            ->select("{$region->table}.title as region, {$region->table}.region_id, {$country->table}.title as country, {$country->table}.country_id")
            ->from($region->table)
            ->join($country->table, "ON {$country->table}.{$country->identity} = {$region->table}.country_id")
            ->where("region_id = $region_id")->fetch();

        if (empty($regions)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $regions[0]);

        $teachers = $this->getTeachers("region = $region_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя в " . $regions[0]['country'] . ', ' . $regions[0]['region'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя в " . $regions[0]['country'] . ', ' . $regions[0]['region']);
        $this->smarty->assign('description', "Учителя в {$regions[0]['country']}, {$regions[0]['region']}. Найти репетитора рядом с домом в {$regions[0]['region']}, {$regions[0]['country']}.");
        $this->smarty->assign('keywords', "репетиторы {$regions[0]['region']}, учителя {$regions[0]['region']}, {$regions[0]['country']} {$regions[0]['region']}");
    }

    function teachersInCountry ($country_id) {
        Application::requireClass('Country');
        $country = new Country();

        $countries = $this->db
            ->select("{$country->table}.title as country, {$country->table}.country_id")
            ->from($country->table)
            ->where("country_id = $country_id")->fetch();

        if (empty($countries)) {
            throw new Exception404();
        }

        $this->smarty->assign('location', $countries[0]);

        $teachers = $this->getTeachers("country = $country_id AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя в " . $countries[0]['country'];
        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя в стране " . $countries[0]['country']);
        $this->smarty->assign('description', "Учителя в стране {$countries[0]['country']}. Найти репетитора в стране {$countries[0]['country']}.");
        $this->smarty->assign('keywords', "репетиторы {$countries[0]['country']}, учителя {$countries[0]['country']}, {$countries[0]['country']}, страна {$countries[0]['country']}");
    }

    function subjectTeachers($pageUrl) {
        $userSubject = new UserSubject();
        $subjects = $this->getSubjects($pageUrl);
        $subject_po = $subjects[0]['subject_po'];
        $subject = $subjects[0]['subject'];

        $this->smarty->assign('subject', $subjects[0]);

        $teachers = $this->getTeachersWithSubjects("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND status = 1");
        $this->smarty->assign('teachers', $teachers);

        $title = "Учителя по $subject_po. Онлайн поиск репетитора рядом с домом.";
        if ($this->page != 1) {
            $title .= ' Страница ' . $this->page . '.';
        }
        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', "Поиск учителя по $subject_po");
        $this->smarty->assign('description', "Учителя по $subject_po онлайн. Найти репетитора рядом с домом. Обучение $subject_po по скайп.");
        $this->smarty->assign('keywords', "учителя по $subject_po, репетиторы, учителя, $subject");
    }

    function getSubjects($pageUrl) {
        Application::requireClass('Subject');
        $subject = new Subject();
        Application::requireClass('Rubric');
        $rubric = new Rubric();

        $subjects = $this->db
            ->select("subject, subject_po, title, {$subject->table}.r_id, s_id")
            ->from($subject->table)
            ->join($rubric->table, "ON {$rubric->table}.r_id = {$subject->table}.r_id")
            ->where("url = '$pageUrl'")
            ->fetch();

        if (empty($subjects)) {
            throw new Exception404();
        }

        $this->smarty->assign('subject_url', $pageUrl);

        return $subjects;
    }

    function getTeachers($where) {
        $user = new User();

        $this->smarty->assign('small_path', $user->images['small_path']);

        $whereCost = '';

        if (isset($_SESSION['search'])) {
            if (isset($_SESSION['search']['from']) && !empty($_SESSION['search']['from'])) {
                $this->smarty->assign('from', $_SESSION['search']['from']);
            }
            if (isset($_SESSION['search']['to']) && !empty($_SESSION['search']['to'])) {
                $this->smarty->assign('to', $_SESSION['search']['to']);
            }
        }

        $db = $this->db
            ->select("SQL_CALC_FOUND_ROWS {$user->table}.u_id, fio, country, region, city, cities.title as city_name, user_pic, info, skype")
            ->from($user->table)
            ->join("cities", "ON cities.city_id = {$user->table}.city")
            ->where($where . ' AND i_am_teacher = 1 AND subjects > 0');

        $result = $db->limit(($this->page - 1) * $this->teachersLimit, $this->teachersLimit)
                  ->fetch();

        $this->assignPages($db->count());

        foreach ($result as &$user) {
            if (!empty($user['info'])) {
                $user['info'] = str_replace('<br>', '. ', $user['info']);
                $user['info'] = strip_tags($user['info']);
                if (mb_strlen($user['info']) > 110) {
                    $user['info'] = mb_substr($user['info'], 0 ,110) . '...';
                }
            }
        }

        return $result;
    }

    function getTeachersWithSubjects($where) {
        $user = new User();
        $userSubject = new UserSubject();

        $this->smarty->assign('small_path', $user->images['small_path']);

        $whereCost = '';

        if (isset($_SESSION['search'])) {
            if (isset($_SESSION['search']['from']) && !empty($_SESSION['search']['from'])) {
                $whereCost .= ' AND cost >= ' . $_SESSION['search']['from'];
                $this->smarty->assign('from', $_SESSION['search']['from']);
            }
            if (isset($_SESSION['search']['to']) && !empty($_SESSION['search']['to'])) {
                $whereCost .= ' AND cost <= ' . $_SESSION['search']['to'];
                $this->smarty->assign('to', $_SESSION['search']['to']);
            }
        }

        $db = $this->db
            ->select("SQL_CALC_FOUND_ROWS {$user->table}.u_id, fio, cost, duration, country, region, city, cities.title as city_name, user_pic, info, skype")
            ->from($user->table)
            ->join($userSubject->table, "ON {$userSubject->table}.u_id = {$user->table}.u_id")
            ->join("cities", "ON cities.city_id = {$user->table}.city")
            ->where($where . $whereCost . ' AND i_am_teacher = 1 AND subjects > 0');

        $result = $db->limit(($this->page - 1) * $this->teachersLimit, $this->teachersLimit)
            ->fetch();

        $this->assignPages($db->count());

        foreach ($result as &$user) {
            if (!empty($user['info'])) {
                $user['info'] = str_replace('<br>', '. ', $user['info']);
                $user['info'] = strip_tags($user['info']);
                if (mb_strlen($user['info']) > 110) {
                    $user['info'] = mb_substr($user['info'], 0 ,110) . '...';
                }
            }
        }

        return $result;
    }

    function assignPages($cnt)  {
        $pages = (int) ($cnt / $this->teachersLimit);
        if ($pages * $this->teachersLimit != $cnt) {
            $pages++;
        }

        $this->smarty->assign('pages', $pages + 1);

        $this->smarty->assign('cur_page', $this->page);

        if ($this->page > 1) {
            $this->smarty->assign('prev_page', $this->page-1);
        }
        if ($this->page < $pages - 1) {
            $this->smarty->assign('next_page', $this->page+1);
        }
    }

    function display () {
        Application::requireClass('User');
        Application::requireClass('UserSubject');

        $country_id = null;
        $region_id = null;
        $city_id = null;
        $pageUrl = null;

        if (count(Router::$path) > 0) {
            $cnt = count(Router::$path);
            $pageUrl = Router::$path[$cnt - 1];

            if ($pageUrl == (string)(int) $pageUrl) {
                $pageUrl = '-';
            } else {
                $cnt--;
            }
            switch ($cnt) {
                case 3:
                    $country_id = Router::$path[2];
                    $region_id = Router::$path[1];
                    $city_id = Router::$path[0];
                    break;
                case 2:
                    $country_id = Router::$path[1];
                    $region_id = Router::$path[0];
                    break;
                case 1:
                    $country_id = Router::$path[0];
                    break;
            }
        }

        $this->page = 1;
        if (isset($_GET['page'])) {
            $this->page = (int) $_GET['page'];
        }

        if (empty($pageUrl)) {
            $this->allTeachers();
        } elseif (empty($country_id)) {
            $this->subjectTeachers($pageUrl);
        } else {
            if ($pageUrl == '-') {
                if (!empty($city_id)) {
                    $this->teachersInCity($city_id);
                } elseif (!empty($region_id)) {
                    $this->teachersInRegion($region_id);
                } elseif (!empty($country_id)) {
                    $this->teachersInCountry($country_id);
                }
            } else {
                if (!empty($city_id)) {
                    $this->subjectTeachersInCity($pageUrl, $city_id);
                } elseif (!empty($region_id)) {
                    $this->subjectTeachersInRegion($pageUrl, $region_id);
                } elseif (!empty($country_id)) {
                    $this->subjectTeachersInCountry($pageUrl, $country_id);
                }
            }
        }

        $this->smarty->assign('page', 'teachers');

        parent::display();
    }
}