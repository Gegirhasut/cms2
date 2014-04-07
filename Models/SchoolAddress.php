<?php
require_once('Models/Base.php');

class SchoolAddress extends Base
{
    public $table = 'at_school_addresses';
    public $identity = 'sa_id';
    public $api_operations = array ('delete' => array ('session_name' => 'school_auth', 'field_name' => 's_id'));

    public $fields = array (
        'sa_id' => array ('type' => 'integer', 'nolist' => 1),
        's_id' => array ('type' => 'select2',
            'title' => 'Школа',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'School',
                'on' => 's_id',
                'show' => 'school_name'
            ),
            'check' => array ('not_empty'),
        ),
        'phones' => array ('type' => 'text', 'title' => 'Телефоны'),
        'emails' => array ('type' => 'text', 'title' => 'Емайлы'),
        'country' => array (
            'type' => 'select2',
            'title' => 'Страна',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            )
        ),
        'region' => array (
            'type' => 'select2',
            'title' => 'Регион',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Region',
                'on' => 'region_id',
                'show' => 'title'
            ),
            'require' => array (
                'name' => 'country_id',
                'id' => 'country_id'
            )
        ),
        'city' => array (
            'type' => 'select2',
            'title' => 'Город',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'City',
                'on' => 'city_id',
                'show' => 'title',
            ),
            'require' => array (
                'name' => 'region_id',
                'id' => 'region_id'
            )
        ),
        'street' => array (
            'type' => 'text',
            'title' => 'Адрес',
            'default' => '',
        ),
        'latitude' => array ('type' => 'hidden'),
        'longitude' => array ('type' => 'hidden'),
        'map' => array (
            'type' => 'yandexmap',
            'fields' => array(
                'latitude' => 'latitude',
                'longitude' => 'longitude',
            ),
            'address' => 'filter_country_id,filter_region_id,filter_city_id,street',
            'nolist' => 1
        )
    );
}