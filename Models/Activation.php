<?php
require_once('Models/Base.php');

class Activation extends Base
{
    public $table = 'at_activations';
    public $identity = 'a_id';

    public $fields = array (
        'a_id' => array ('type' => 'integer', 'nolist' => 1),
        'u_id' => array ('type' => 'text', 'title' => 'User Id'),
        'code' => array ('type' => 'text', 'title' => 'Код активации')
    );
}