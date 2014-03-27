<?php
chdir(dirname(__FILE__) . '/..');
$_SERVER['SERVER_NAME'] = (isset($_SERVER["OS"]) && $_SERVER["OS"] == 'Windows_NT') ? 'localhost' : '';
require_once ('Configs/Config.php');

require_once('Helpers/Email.php');
$email = new Email();

$mail = 'max077@mail.ru';

if (isset($argv[1])) {
    $mail = $argv[1];
}

$email->LoadTemplate('new_message_cron');
$email->SetValue('fio', 'Попельницкий Максим Викторович');
$email->SetValue('code', 'asass');
$email->SetValue('cnt', 5);
$result = $email->Send($mail, 'Тестовое ообщение. Все Учителя.');
if ($result) {
    echo "sended to $mail!\n";
} else {
    echo "rejected to $mail!\n";
}