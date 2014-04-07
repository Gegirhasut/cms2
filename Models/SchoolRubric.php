<?php
require_once('Models/Base.php');

class SchoolRubric extends Base
{
    public $table = 'at_school_rubrics';
    public $identity = 'sr_id';
    public $api_fields = array('sr_id' => 1, 'title' => 1);

    public $fields = array (
        'sr_id' => array ('type' => 'integer', 'nolist' => 1),
        'title' => array ('type' => 'text', 'title' => 'Тип школы'),
        'title_m' => array ('type' => 'text', 'title' => 'Множественное'),
        'title_search' => array ('type' => 'text', 'title' => 'Поиск чего?'),
        'r_url' => array ('type' => 'text', 'title' => 'Ссылка'),
    );
}