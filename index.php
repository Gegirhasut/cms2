<?php
require_once('Application/Application.php');
try {
    Application::run();
} catch (Exception $ex) {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        echo $ex->getMessage();
    } else {
        mail('max077@mail.ru', "[{$_SERVER['SERVER_NAME']}] error", $ex->getMessage() . print_r($_SERVER, true));
    }
}