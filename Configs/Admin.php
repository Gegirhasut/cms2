<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $GLOBALS['admin'] = array (
        'login' => 'admin',
        'password' => 'demo',
    );
} else {
    $GLOBALS['admin'] = array (
        'login' => 'admin',
        'password' => 'demo',
    );
}
class Admin {

}