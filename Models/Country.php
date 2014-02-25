<?php

class Country
{
    public $table = 'at_countries';
    public $identity = 'c_id';
    public $api_fields = array();

    public $fields = array (
        'c_id' => array ('type' => 'integer', 'nolist' => 1),
        'country' => array ('type' => 'text', 'title' => 'Страна'),
    );
}