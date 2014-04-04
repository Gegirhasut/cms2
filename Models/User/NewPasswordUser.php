<?php
require_once('Models/Base.php');

class NewPasswordUser extends Base
{
    public $table = 'at_users';

    public $fields = array (
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty', 'strict'), 'placeholder' => 'Введите новый пароль'),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password', 'placeholder' => 'Введите пароль еще раз'),
   );
}