<?php
require_once('Models/Base.php');

class RemindPasswordSchool extends Base
{
    public $table = 'at_remind_password_school';
    public $identity = 'rps_id';

    public $fields = array (
        'rps_id' => array ('type' => 'integer', 'nolist' => 1),
        'code' => array ('type' => 'text', 'title' => 'Код восстановления пароля'),
        's_id' => array ('type' => 'text', 'title' => 'School Id'),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty'))
    );
}