<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $GLOBALS['admin'] = array (
        'login' => 'admin',
        'password' => 'demo',
    );
} else {
    $GLOBALS['admin'] = array (
        'login' => 'max077@mail.ru',
        'password' => 'tutors123!',
    );
}
class Admin {

}