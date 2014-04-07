<?php
require_once('Models/Base.php');

class ChangeEmailSchool extends Base
{
    public $table = 'at_change_email_school';
    public $identity = 'ces_id';

    public $fields = array (
        'ces_id' => array ('type' => 'integer', 'nolist' => 1),
        's_id' => array ('type' => 'text', 'title' => 'School Id'),
        'code' => array ('type' => 'text', 'title' => 'Код смены'),
        'email' => array ('type' => 'text', 'title' => 'Новый Email', 'check' => array ('email'))
    );
}