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

    function post () {
        require_once('Helpers/json.php');

        if (!isset(Router::$path[0])) {
            echo arrayToJson(array('error' => 'Сообщение не может быть доставлено выбранному пользователю'));
            exit;
        }

        $u_id_to = Router::$path[0];

        if (!isset($_SESSION['user_auth'])) {
            echo arrayToJson(array('error' => 'Авторизуйтесь, пожалуйста!'));
            exit;
        }

        Application::requireClass('User');
        $user = new User();
        $user = $this->db->select('fio, email')->from($user->table)->where($user->identity . " = $u_id_to")->fetch();
        if (empty($user)) {
            echo arrayToJson(array('error' => 'Пользователь не существует!'));
            exit;
        }

        $u_id_from = $_SESSION['user_auth']['u_id'];
        if ($u_id_from == $u_id_to) {
            echo arrayToJson(array('success' => 'Вы не можете отправлять сообщение самому себе!'));
            exit;
        }

        Application::requireClass('Message');
        $message = new Message();
        require_once('Helpers/ObjectParser.php');
        ObjectParser::parse($_POST, $message);

        if (empty($message->message)) {
            echo $message->message;exit;
            echo arrayToJson(array('success' => 'Пустое сообщение!'));
            exit;
        } else {
            if (mb_strlen($message->message, 'UTF-8') == 255) {
                $message->subject = $message->message;
            } else {
                $message->subject = mb_substr($message->message, 0, 255, 'UTF-8') . '...';
            }
        }
        $message->u_id_from = $u_id_from;
        $message->u_id_to = $u_id_to;

        $this->db->insert($message)->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('new_message');
        $email->SetValue('to', $user[0]['fio']);
        $email->SetValue('from', $_SESSION['user_auth']['fio']);
        $email->SetValue('subject', $message->subject);
        $email->SetValue('message', $message->message);
        $email->Send($user[0]['email'], 'Вам пришло новое сообщение на сайте Все Учителя!');

        $_SESSION['cabinet_message'][] = "Сообщение успешно отправлено!";

        $this->db->sql("UPDATE at_users SET messages=messages+1 WHERE u_id = $u_id_to");

        echo arrayToJson(array('success' => '/user/' . $u_id_to));
        exit;
    }

    function loadUser($user_id) {
        Application::requireClass('User');
        $user = new User();
        Application::requireClass('City');
        $city = new City();
        Application::requireClass('Region');
        $region = new Region();
        Application::requireClass('Country');
        $country = new Country();

        $users = $this->db
            ->select("{$city->table}.title as city, {$region->table}.title as region, {$country->table}.title as country, {$user->table}.fio, {$user->table}.user_pic, {$user->table}.info, {$user->table}.skype, {$user->table}.email, {$user->table}.u_id")
            ->from($user->table)
            ->join($city->table, "ON {$city->table}.city_id = {$user->table}.city")
            ->join($region->table, "ON {$region->table}.region_id = {$user->table}.region")
            ->join($country->table, "ON {$country->table}.country_id = {$user->table}.country")
            ->where($user->identity . " = $user_id AND status = 1")
            ->fetch();

        if (empty($user)) {
            throw new Exception404();
        }

        $this->smarty->assign('user', $users[0]);

        $this->smarty->assign('small_path', $user->images['small_path']);

        return $users[0];
    }

    function loadSubjects($user_id) {
        Application::requireClass('Subject');
        $subject = new Subject();
        Application::requireClass('UserSubject');
        $userSubject = new UserSubject();

        $subjects = $this->db
            ->select()
            ->from($userSubject->table)
            ->join($subject->table, "ON {$subject->table}.s_id = {$userSubject->table}.s_id")
            ->where("{$userSubject->table}.u_id = " . $user_id)->fetch();

        $this->smarty->assign('subjects', $subjects);

        return $subjects;
    }

    function display () {
        if (!isset(Router::$path[0])) {
            throw new Exception404();
        }

        $user_id = (int) Router::$path[0];
        $user = $this->loadUser($user_id);
        $subjects = $this->loadSubjects($user_id);

        $this->smarty->assign('h1', $user['fio']);

        if (empty($subjects)) {
            $this->smarty->assign('title', $user['fio']);
            $this->smarty->assign('description', $user['fio'] . '. Город ' . $user['city'] . '.');
            $this->smarty->assign('keywords', $user['fio'] . ',' . $user['city']);
        } else {
            $subjects_title = '';
            $subjects_title_po = '';
            foreach ($subjects as $subject) {
                $subjects_title_po .= empty($subjects_title_po) ? $subject['subject_po'] : ', ' . $subject['subject_po'];
                $subjects_title .= empty($subjects_title) ? $subject['subject'] : ', ' . $subject['subject'];
            }
            $this->smarty->assign('title', $user['fio'] . ' - учитель по ' . $subjects_title_po . ' в городе ' . $user['city'] . '.');
            $this->smarty->assign('description', $user['fio'] . ' - учитель по ' . $subjects_title_po . ' в городе ' . $user['city'] . '.');
            $this->smarty->assign('keywords', $user['fio'] . ', учитель, репетитор, ' . $subjects_title . ', ' . $user['city']);

            $this->smarty->assign('subject_po', $subjects_title_po);
        }

        $this->smarty->assign('page', 'user');

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }

        parent::display();
    }
}