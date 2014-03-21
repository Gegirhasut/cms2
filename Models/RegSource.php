<?php
require_once('Models/Base.php');

class RegSource extends Base
{
    public $table = 'at_reg_sources';
    public $identity = 'rs_id';

    public $fields = array (
        'rs_id' => array ('type' => 'integer', 'nolist' => 1),
        'source' => array ('type' => 'text', 'title' => 'Источник'),
        'source_md5' => array ('type' => 'text', 'title' => 'md5 код'),
        'cnt' => array ('type' => 'text', 'title' => 'Количество'),
    );
}