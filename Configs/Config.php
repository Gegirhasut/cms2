<?php
$GLOBALS['admin_mail'] = 'max077@mail.ru';

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $GLOBALS['mysql'] = array (
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'qweqwe',
        'database' => 'alltutors_ru'
    );
} else {
    $GLOBALS['mysql'] = array (
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'qweqwe',
        'database' => 'alltutors_ru'
    );
}

$GLOBALS['memcache'] = array (
    'ip' => '127.0.0.1'
);

$GLOBALS['salt'] = 'S1!h_A0';
$GLOBALS['admin'] = 'max077@mail.ru';
$GLOBALS['from'] = 'support@alltutors.ru';
$GLOBALS['from_name'] = 'Все учителя';