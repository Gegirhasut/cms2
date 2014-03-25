<?php
require_once('Application/Application.php');
try {
    Application::run();
} catch (Exception $ex) {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        echo $ex->getMessage() . "<br><br>Trace:<br>";
        print_r($ex->getTrace());
    } else {
        mail('max077@mail.ru', "[{$_SERVER['SERVER_NAME']}] error", $ex->getMessage() . "\r\n\r\nSERVER:\r\n" . print_r($_SERVER, true) , "\r\nTrace:\r\n" . print_r($ex->getTrace(), true));
    }
}