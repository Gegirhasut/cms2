<?php
require_once('Models/Base.php');

class NewPassword extends Base
{
    public $fields = array (
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty', 'strict')),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password'),
    );
}