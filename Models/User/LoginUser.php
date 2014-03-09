<?php
require_once('Models/Base.php');

class LoginUser extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty')),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty')),
   );
}