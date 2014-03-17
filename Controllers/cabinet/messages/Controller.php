<?php
require_once('Controllers/cabinet/BaseController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseController
{
    protected $countOnPage = 50;
    protected $countOnFullPage = 10;

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
            $_SESSION['cabinet_message'][] = "Пустое сообщение!";
            echo arrayToJson(array('success' => '/cabinet/messages/' . $u_id_to));
            exit;
        } else {
            if (mb_strlen($message->message, 'UTF-8') <= 255) {
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

        echo arrayToJson(array('success' => '/cabinet/messages/' . $u_id_to));
        exit;
    }

    function showMessages() {
        Application::requireClass('Message');
        $message = new Message();
        Application::requireClass('User');
        $user = new User();

        /*$db = $this->db
            ->select("SQL_CALC_FOUND_ROWS m1.m_id, m1.subject, m1.readed, m1.u_id_from, m1.posted_time, {$user->table}.fio, {$user->table}.user_pic")
            ->from($message->table . ' as m1')
            ->join($user->table, "ON {$user->table}.u_id = m1.u_id_from")
            ->where("u_id_to = " . $_SESSION['user_auth']['u_id'] . ' AND posted_time = (SELECT MAX( posted_time ) FROM at_messages AS m2 WHERE m2.u_id_from = m1.u_id_from)')
            ->orderBy('m1.posted_time', 'DESC')
            ->limit(0, $this->countOnPage);*/

        $db = $this->db->select("SQL_CALC_FOUND_ROWS m_id, readed, at_messages.u_id_from, at_messages.u_id_to, posted_time, message, subject, {$user->table}.fio, {$user->table}.user_pic")
            ->from("at_messages")
            ->innerJoin("(SELECT u_id_from, MAX(POSTED_TIME) AS max_time
                    FROM at_messages AS m2
                    WHERE u_id_to={$_SESSION['user_auth']['u_id']}
                    GROUP BY u_id_from
                    ORDER BY max_time
                    DESC LIMIT 0, {$this->countOnPage}
                 )
                 AS mt", "ON mt.u_id_from = at_messages.u_id_from AND mt.max_time=at_messages.posted_time"
            )->join($user->table, "ON {$user->table}.u_id = at_messages.u_id_from");

        $messages = $db->fetch();

        $count = $db->count();

        $pages = $count / $this->countOnPage;
        if ($pages * $this->countOnPage < $count) {
            $pages++;
        }

        $this->smarty->assign('pages', $pages);
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('small_path', $user->images['small_path']);

        $this->smarty->assign('h1', 'Персональные сообщения');
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'messages');
    }

    function showMessagesWith($u_id_from) {
        Application::requireClass('Message');
        $message = new Message();
        Application::requireClass('User');
        $user = new User();

        $users = $this->db->select('fio, user_pic, u_id')->from($user->table)->where($user->identity . ' = ' . $u_id_from)->fetch();

        if (empty($users)) {
            throw new Exception404();
        }

        $where = "(u_id_to = " . $_SESSION['user_auth']['u_id'] . " AND u_id_from = $u_id_from) OR (u_id_from = " . $_SESSION['user_auth']['u_id'] . " AND u_id_to = $u_id_from)";
        if (isset($_GET['ajax'])) {
            $where = 'm_id < ' . (int) $_GET['from'] . ' AND (' . $where . ')';
        }

        $db = $this->db
            ->select("m1.m_id, m1.readed, m1.u_id_from, m1.u_id_to, m1.posted_time, m1.message, {$user->table}.fio, {$user->table}.user_pic")
            ->from($message->table . ' as m1')
            ->join($user->table, "ON {$user->table}.u_id = m1.u_id_from")
            ->where($where)
            ->orderBy('m1.posted_time', 'DESC')
            ->limit(0, $this->countOnFullPage);

        $messages = $db->fetch();

        $readed_messages = array ();
        foreach ($messages as &$message) {
            if ($message['u_id_to'] == $_SESSION['user_auth']['u_id'] && $message['readed'] == 0) {
                $message['readed'] = 1;
                $readed_messages[] = $message['m_id'];
            }
        }

        if (!empty($readed_messages)) {
            $cnt = count($readed_messages);
            $this->db->sql("UPDATE {$user->table} SET messages = messages - " . $cnt . " WHERE u_id = " . $_SESSION['user_auth']['u_id']);
            $readed_messages = implode(',', $readed_messages);
            $this->db->sql("UPDATE at_messages SET readed = 1 WHERE m_id IN ($readed_messages)");

            $messages_cnt = $this->smarty->get_template_vars('messages_cnt');
            $this->smarty->assign('messages_cnt', $messages_cnt - $cnt);
        }

        $this->smarty->assign('messages', array_reverse($messages));
        $this->smarty->assign('small_path', $user->images['small_path']);

        if (isset($_GET['ajax'])) {
            echo $this->smarty->fetch('pages/cabinet/messages_with_ajax.tpl');
            exit;
        }

        $this->smarty->assign('h1', 'Переписка с ' . $users[0]['fio']);
        $this->smarty->assign('user_from', $users[0]);
        $this->smarty->assign('page', 'cabinet');
        $this->smarty->assign('cabinet_page', 'messages_with');

        if (isset($_SESSION['cabinet_message'])) {
            $this->smarty->assign('cabinet_message', $_SESSION['cabinet_message']);
            unset($_SESSION['cabinet_message']);
        }
    }

    function display () {
        $this->prepareCabinet();

        if (isset(Router::$path[0])) {
            $this->showMessagesWith(Router::$path[0]);
        } else {
            $this->showMessages();
        }

        parent::display();
    }
}