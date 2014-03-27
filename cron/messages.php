<?php
chdir(dirname(__FILE__) . '/..');
$_SERVER['SERVER_NAME'] = (isset($_SERVER["OS"]) && $_SERVER["OS"] == 'Windows_NT') ? 'localhost' : '';
require_once ('Configs/Config.php');
require_once ('Database/DBFactory.php');

$db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

require_once('Models/User/User.php');
$user = new User();
require_once('Models/Message/Message.php');
$message = new Message();
require_once('Models/User/UserAutoLogin.php');
$userAL = new UserAutoLogin();
$userAL->page = 'messages';

$start_u_id = 0;

$sended = 0;
$rejected = 0;

do {
    $users = $db->select('u_id, email, fio, count(u_id) as cnt')
        ->from($user->table)
        ->join($message->table, "ON {$message->table}.u_id_to = {$user->table}.u_id")
        ->where("u_id > $start_u_id AND readed = 0 AND last_notified < last_login")
        ->groupBy('u_id')
        ->having('cnt > 0')
        ->orderBy('u_id')
        ->limit(0, 100)
        ->fetch();

    if (empty($users)) {
        echo "Pasing done! Sended messages $sended, rejected $rejected.";
        exit;
    }

    foreach ($users as $u) {
        $start_u_id = $u['u_id'];
        $userAL->code = md5(time() . rand(0,1000) . $start_u_id . $GLOBALS['salt']);
        $userAL->u_id = $start_u_id;
        $db->insert($userAL)
            ->onduplicate($userAL)
            ->execute();

        require_once('Helpers/Email.php');
        $email = new Email();

        $email->LoadTemplate('new_message_cron');
        $email->SetValue('fio', $u['fio']);
        $email->SetValue('code', $userAL->code);
        $email->SetValue('cnt', $u['cnt']);
        echo "Trying to send message to {$u['email']} ";
        $result = $email->Send($u['email'], 'Новые сообщения на сайте Все Учителя');
        if ($result) {
            echo "sended.\n";
            $sended++;
        } else {
            echo "rejected.\n";
            $rejected++;
        }

        $db->sql("UPDATE at_users SET last_notified = CURRENT_TIMESTAMP WHERE u_id = $start_u_id");
    }
} while (true);