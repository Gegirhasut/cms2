<?php
require_once('Models/Base.php');

class Rubric extends Base
{
    public $table = 'at_rubrics';
    public $identity = 'r_id';
    public $sort = 'sort';
    public $api_fields = array('r_id' => 1, 'title' => 1);

    public $fields = array (
        'r_id' => array ('type' => 'integer', 'nolist' => 1),
        'title' => array ('type' => 'text', 'title' => 'Рубрика'),
        'r_url' => array ('type' => 'text', 'title' => 'Ссылка'),
        'sort' => array ('type' => 'sort', 'title' => 'Порядок'),
    );
}