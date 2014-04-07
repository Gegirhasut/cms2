<?php
require_once('Models/Base.php');

class SchoolAddressForm extends Base
{
    public $table = 'at_school_addresses';
    public $identity = 'sa_id';

    public $fields = array (
        'sa_id' => array ('type' => 'integer', 'nolist' => 1),
        'phones' => array (
            'type' => 'text',
            'title' => 'Телефоны',
            'placeholder' => 'Введите телефоны',
            'maxlength' => 255
        ),
        'emails' => array (
            'type' => 'text',
            'title' => 'Емайлы',
            'placeholder' => 'Введите емейлы',
            'maxlength' => 255
        ),
        'country' => array (
            'type' => 'select2_opt',
            'title' => 'Страна',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            ),
            'relative_fields' => array (
                'region' => 'enable',
                'city' => 'disable'
            ),
            'minimumInputLength' => 1,
            'maxSearchLetters' => 1,
            'placeholder' => 'Выберите страну'
        ),
        'region' => array (
            'type' => 'select2_opt',
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
            ),
            'relative_fields' => array (
                'city' => 'enable'
            ),
            'select_fields' => array (
                'country_id' => 'country',
            ),
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
            'placeholder' => 'Выберите регион'
        ),
        'city' => array (
            'type' => 'select2_opt',
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
            ),
            'select_fields' => array (
                'country_id' => 'country',
                'region_id' => 'region'
            ),
            'minimumInputLength' => 0,
            'maxSearchLetters' => 1,
            'placeholder' => 'Выберите город'
        ),
        'street' => array (
            'type' => 'text',
            'title' => 'Адрес',
            'placeholder' => 'Введите адрес',
            'default' => '',
            'maxlength' => 255
        ),
        'latitude' => array ('type' => 'hidden'),
        'longitude' => array ('type' => 'hidden'),
        'map' => array (
            'type' => 'yandexmap',
            'fields' => array(
                'latitude' => 'latitude',
                'longitude' => 'longitude',
            ),
            'address' => 's2id_country,region,city,street',
            'width' => '100%',
            'height' => '310px'
        )
    );
}