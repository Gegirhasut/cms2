<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = false;
    public $db = null;
    public $page = 1;

    public $schoolsLimit = 10;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function getRubric ($rubric_url) {
        Application::requireClass('SchoolRubric');
        $rubric = new SchoolRubric();

        $rubrics = $this->db->select()->from($rubric->table)->where("r_url = '$rubric_url'")->fetch();
        if (!empty($rubrics)) {
            $this->smarty->assign('rubric', $rubrics[0]);
            return $rubrics[0];
        }
        return 0;
    }

    function getSubject ($subject_url) {
        Application::requireClass('SchoolSubject');
        $subject = new SchoolSubject();

        $subjects = $this->db->select()->from($subject->table)->where("url = '$subject_url'")->fetch();
        if (!empty($subjects)) {
            $this->smarty->assign('subject', $subjects[0]);
            return $subjects[0];
        }
        return 0;
    }

    function getLocationForCity($city_id) {
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

        return $cities[0];
    }

    function getLocationForRegion($region_id) {
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

        return $regions[0];
    }

    function getLocationForCountry($country_id) {
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

        return $countries[0];
    }

    function getAllSchools($rubric_url, $subject_url, $country_id, $region_id, $city_id)
    {
        $search_rubric = null;
        if (!is_null($rubric_url)) {
            $search_rubric = $this->getRubric($rubric_url);
            $r_id = $search_rubric['sr_id'];
        } else {
            $r_id = 0;
        }

        $search_subject = null;
        if (!is_null($subject_url)) {
            $search_subject = $this->getSubject($subject_url);
            $s_id = $search_subject['ss_id'];
        } else {
            $s_id = 0;
        }

        $search_city = null;
        $search_region = null;
        $search_country = null;

        if (!empty($city_id)) {
            $search_city = $this->getLocationForCity($city_id);
        } elseif (!empty($region_id)) {
            $search_region = $this->getLocationForRegion($region_id);
        } elseif (!empty($country_id)) {
            $search_country = $this->getLocationForcountry($country_id);
        }

        Application::requireClass('School');
        $school = new School();
        $this->smarty->assign('small_path', $school->images['small_path']);
        $db = $this->db->select("{$school->table}.s_id")->from($school->table);

        $where = '';

        if ($r_id != 0) {
            $where .= ' AND sr_id = ' . $r_id;
        }

        Application::requireClass('SchoolSchoolSubject');
        $schoolSubject = new SchoolSchoolSubject();

        if ($s_id != 0) {
            $db = $db->join($schoolSubject->table, "ON {$schoolSubject->table}.s_id = {$school->table}.s_id");
            $where .= " AND {$schoolSubject->table}.ss_id = " . $s_id;
        }

        Application::requireClass('SchoolAddress');
        $schoolAddress = new SchoolAddress();

        $groupBy = null;
        if (!empty($city_id)) {
            $db = $db->join($schoolAddress->table, "ON {$schoolAddress->table}.s_id = {$school->table}.s_id");
            $where .= " AND {$schoolAddress->table}.city = " . $city_id;
            $groupBy = "{$schoolAddress->table}.s_id";
        } elseif (!empty($region_id)) {
            $db = $db->join($schoolAddress->table, "ON {$schoolAddress->table}.s_id = {$school->table}.s_id");
            $where .= " AND {$schoolAddress->table}.region = " . $region_id;
            $groupBy = "{$schoolAddress->table}.s_id";
        } elseif (!empty($country_id)) {
            $db = $db->join($schoolAddress->table, "ON {$schoolAddress->table}.s_id = {$school->table}.s_id");
            $where .= " AND {$schoolAddress->table}.country = " . $country_id;
            $groupBy = "{$schoolAddress->table}.s_id";
        }

        $db = $db->where('status = 1' . $where);
        if (!is_null($groupBy)) {
            $db = $db->groupBy($groupBy);
        }

        $schools = $db->limit(($this->page - 1) * $this->schoolsLimit, $this->schoolsLimit)
            ->fetch();

        $this->assignPages($db->count());

        if (!empty($schools)) {
            $ids = '';
            foreach ($schools as $s => $d) {
                $ids .= empty($ids) ? $d['s_id'] : ",{$d['s_id']}";
            }

            Application::requireClass('SchoolSubject');
            $subject = new SchoolSubject();
            Application::requireClass('City');
            $city = new City();
            Application::requireClass('Country');
            $country = new Country();

            if (!empty($city_id)) {
                $group_concat_address = "{$schoolAddress->table}.street";
            } elseif (!empty($country_id)) {
                $group_concat_address = "{$city->table}.title, ', ', {$schoolAddress->table}.street";
            } else {
                $group_concat_address = "{$country->table}.title, ', ', {$city->table}.title, ', ', {$schoolAddress->table}.street";
            }

            $db = $this->db
                ->select("{$school->table}.s_id, school_name, info, banner, GROUP_CONCAT(DISTINCT {$subject->table}.subject SEPARATOR '<br>') as subjects, GROUP_CONCAT(DISTINCT CONCAT($group_concat_address) SEPARATOR '<br>') as addresses")
                ->from($school->table)
                ->join($schoolSubject->table, "ON {$schoolSubject->table}.s_id = {$school->table}.s_id")
                ->join($schoolAddress->table, "ON {$schoolAddress->table}.s_id = {$school->table}.s_id")
                ->join($subject->table, "ON {$subject->table}.ss_id = {$schoolSubject->table}.ss_id");

            if (empty($city_id)) {
                $db = $db->join($city->table, "ON {$city->table}.city_id = {$schoolAddress->table}.city");
            }
            if (empty($country_id)) {
                $db = $db->join($country->table, "ON {$country->table}.country_id = {$schoolAddress->table}.country");
            }

            $schools = $db
                ->where("{$school->table}.s_id IN ($ids)")
                ->groupBy("{$school->table}.s_id")
                ->fetch();

            foreach ($schools as &$user) {
                if (!empty($user['info'])) {
                    $user['info'] = str_replace('<br>', '. ', $user['info']);
                    $user['info'] = strip_tags($user['info']);
                    if (mb_strlen($user['info']) > 110) {
                        $user['info'] = mb_substr($user['info'], 0 ,200, 'UTF-8') . '...';
                    }
                }
            }
        }

        $this->smarty->assign('schools', $schools);

        if(!is_null($search_rubric)) {
            $title = $search_rubric['title_m'];
            $search_str = 'Поиск ' . $search_rubric['title_search'];
            $keywords = $search_rubric['title_m'] . ', поиск';
        } else {
            $title = 'Обучающие центры';
            $search_str = 'Поиск обучающих центров';
            $keywords = "обучающие центры, поиск";
        }

        if (!is_null($search_subject)) {
            $title .= " по {$search_subject['subject_po']}";
            $search_str .= " по {$search_subject['subject_po']}";
            $keywords .= ',' . $search_subject['subject'];
        }

        if (!is_null($search_city)) {
            $title .= " в городе {$search_city['city']}";
            $search_str .= " в городе {$search_city['city']}";
            $keywords .= ',' . $search_city['city'];
        }
        if (!is_null($search_region)) {
            $title .= " в регионе {$search_region['region']}";
            $search_str .= " в регионе {$search_region['region']}";
            $keywords .= ',' . $search_region['region'];
        }
        if (!is_null($search_country)) {
            $title .= " в стране {$search_country['country']}";
            $search_str .= " в стране {$search_country['country']}";
            $keywords .= ',' . $search_country['country'];
        }

        if ($this->page != 1) {
            $title .= '. Страница ' . $this->page . '.';
        }

        $this->smarty->assign('title', $title);
        $this->smarty->assign('h1', $search_str);
        $this->smarty->assign('description', $title);
        $this->smarty->assign('keywords', $keywords);

    }

    function assignPages($cnt)  {
        $pages = (int) ($cnt / $this->schoolsLimit);
        if ($pages * $this->schoolsLimit != $cnt) {
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

        $rubric_url = null;
        $subject_url = null;
        $cnt = count(Router::$path);

        if ($cnt > 0) {
            switch ($cnt) {
                case 5:
                    $city_id = Router::$path[0];
                    $region_id = Router::$path[1];
                    $country_id = Router::$path[2];
                    $subject_url = Router::$path[3];
                    $rubric_url = Router::$path[4];
                    break;
                case 4:
                    $region_id = Router::$path[0];
                    $country_id = Router::$path[1];
                    $subject_url = Router::$path[2];
                    $rubric_url = Router::$path[3];
                    break;
                case 3:
                    $country_id = Router::$path[0];
                    $subject_url = Router::$path[1];
                    $rubric_url = Router::$path[2];
                    break;
                case 2:
                    $subject_url = Router::$path[0];
                    $rubric_url = Router::$path[1];
                    break;
                case 1:
                    $rubric_url = Router::$path[0];
                    break;
            }
        }

        if ($rubric_url === "0") {
            $rubric_url = null;
        }

        if ($subject_url === "0") {
            $subject_url = null;
        }

        $this->page = 1;
        if (isset($_GET['page'])) {
            $this->page = (int) $_GET['page'];
        }

        $this->getAllSchools($rubric_url, $subject_url, $country_id, $region_id, $city_id);

        $this->smarty->assign('page', 'schools');

        parent::display();
    }
}