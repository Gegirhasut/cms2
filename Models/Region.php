<?php
require_once('Models/Base.php');

class Region extends Base
{
    public $table = 'regions';
    public $identity = 'region_id';
    public $api_fields = array('region_id' => 1, 'title' => 1, 'country_id' => 1);

    public $fields = array (
        'region_id' => array ('type' => 'integer', 'nolist' => 1),
        'title' => array ('type' => 'text', 'title' => 'Регион'),
        'country_id' => array ('type' => 'select',
            'title' => 'Страна',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            )
        ),
    );
}