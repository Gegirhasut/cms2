<?php
require_once('Models/Base.php');

class UserAutoLogin extends Base
{
    public $table = 'at_users_autologin';
    public $identity = 'ua_id';

    public $fields = array (
        'ua_id' => array ('type' => 'integer', 'nolist' => 1),
        'u_id' => array ('type' => 'text', 'title' => 'User Id'),
        'code' => array ('type' => 'text', 'title' => 'Код доступа'),
        'page' => array ('type' => 'text', 'title' => 'Страница доступа'),
    );
}