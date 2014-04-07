<?php
require_once('Models/Base.php');

class SchoolActivation extends Base
{
    public $table = 'at_school_activations';
    public $identity = 'sa_id';

    public $fields = array (
        'sa_id' => array ('type' => 'integer', 'nolist' => 1),
        's_id' => array ('type' => 'text', 'title' => 'School Id'),
        'code' => array ('type' => 'text', 'title' => 'Код активации')
    );
}