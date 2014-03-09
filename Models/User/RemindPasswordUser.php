<?php
require_once('Models/Base.php');

class RemindPasswordUser extends Base
{
    public $table = 'at_users';

    public $fields = array (
        'email' => array ('type' => 'email', 'title' => 'Email', 'check' => array ('email', 'not_empty'), 'placeholder' => 'Введите Ваш email'),
   );
}