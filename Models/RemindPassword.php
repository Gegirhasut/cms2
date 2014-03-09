<?php
require_once('Models/Base.php');

class RemindPassword extends Base
{
    public $table = 'at_remind_password';
    public $identity = 'rp_id';

    public $fields = array (
        'rp_id' => array ('type' => 'integer', 'nolist' => 1),
        'code' => array ('type' => 'text', 'title' => 'Код восстановления пароля'),
        'u_id' => array ('type' => 'text', 'title' => 'User Id'),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty'))
    );
}