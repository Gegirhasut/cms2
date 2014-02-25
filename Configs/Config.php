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