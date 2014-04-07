<?php
require_once('Models/Base.php');

class LoginSchool extends Base
{
    public $table = 'at_schools';

    public $fields = array (
        'email' => array (
            'type' => 'email',
            'title' => 'Email',
            'check' => array ('email', 'not_empty'),
            'placeholder' => 'Введите Ваш email'
        ),
        'password' => array (
            'type' => 'password',
            'title' => 'Пароль',
            'check' => array ('not_empty'),
            'placeholder' => 'Введите Ваш пароль'
        ),
   );
}