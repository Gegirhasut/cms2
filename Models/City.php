<?php
require_once('Models/Base.php');

class City extends Base
{
    public $table = 'cities';
    public $identity = 'city_id';
    public $api_fields = array('city_id' => 1, 'title' => 1, 'region_id' => 1);

    public $fields = array (
        'city_id' => array ('type' => 'integer', 'nolist' => 1),
        'country_id' => array ('type' => 'select',
            'title' => 'Страна',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            )
        ),
        'region_id' => array ('type' => 'select',
            'title' => 'Регион',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Region',
                'on' => 'region_id',
                'show' => 'title'
            )
        ),
        'title' => array ('type' => 'text', 'title' => 'Город'),
    );
}