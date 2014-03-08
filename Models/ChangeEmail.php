<?php
require_once('Models/Base.php');

class ChangeEmail extends Base
{
    public $table = 'at_change_email';
    public $identity = 'ce_id';

    public $fields = array (
        'ce_id' => array ('type' => 'integer', 'nolist' => 1),
        'u_id' => array ('type' => 'text', 'title' => 'User Id'),
        'code' => array ('type' => 'text', 'title' => 'Код смены'),
        'email' => array ('type' => 'text', 'title' => 'Новый Email', 'check' => array ('email'))
    );
}