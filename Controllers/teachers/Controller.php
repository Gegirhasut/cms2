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
        $teachers = $this->getTeachers("status = 1", true);

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

        $this->smarty->assign('city', $cities[0]);

        $teachers = $this->getTeachers("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND city = $city_id AND status = 1");
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

        $this->smarty->assign('city', $cities[0]);

        $teachers = $this->getTeachers("city = $city_id AND status = 1", true);
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

    function subjectTeachers($pageUrl) {
        $userSubject = new UserSubject();
        $subjects = $this->getSubjects($pageUrl);
        $subject_po = $subjects[0]['subject_po'];
        $subject = $subjects[0]['subject'];

        $this->smarty->assign('subject', $subjects[0]);

        $teachers = $this->getTeachers("{$userSubject->table}.s_id = {$subjects[0]['s_id']} AND status = 1");
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

        return $subjects;
    }

    function getTeachers($where, $group = false) {
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
            ->select("SQL_CALC_FOUND_ROWS {$user->table}.u_id, duration, cost, fio, country, region, city, cities.title as city_name, user_pic, info, skype")
            ->from($user->table)
            ->join($userSubject->table, "ON {$userSubject->table}.u_id = {$user->table}.u_id")
            ->join("cities", "ON cities.city_id = {$user->table}.city")
            ->where($where . $whereCost);

        if ($group) {
            $db = $db->groupBy($user->table . '.u_id');
        }

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

        $city_id = null;
        $pageUrl = null;

        if (isset(Router::$path[1])) {
            $pageUrl = Router::$path[1];
            $city_id = (int) Router::$path[0];
        } else if (isset(Router::$path[0])) {
            $pageUrl = Router::$path[0];

            if ($pageUrl == (string)(int) $pageUrl) {
                $city_id = $pageUrl;
                $pageUrl = '-';
            }
        }

        $this->page = 1;
        if (isset($_GET['page'])) {
            $this->page = (int) $_GET['page'];
        }

        if (empty($pageUrl)) {
            $this->allTeachers();
        } elseif (empty($city_id)) {
            $this->subjectTeachers($pageUrl);
        } else {
            if ($pageUrl == '-') {
                $this->teachersInCity($city_id);
            } else {
                $this->subjectTeachersInCity($pageUrl, $city_id);
            }
        }

        $this->smarty->assign('page', 'teachers');

        parent::display();
    }
}