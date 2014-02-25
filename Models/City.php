<?php

class City
{
    public $table = 'at_cities';
    public $identity = 'city_id';
    public $api_fields = array();

    public $fields = array (
        'city_id' => array ('type' => 'integer', 'nolist' => 1),
        'city' => array ('type' => 'text', 'title' => 'Город'),
    );
}