<?php
require_once('Models/Base.php');

class PersonalUser extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'fio' => array (
            'type' => 'text',
            'title' => 'ФИО',
            'check' => array ('not_empty'),
            'placeholder' => 'Ваше ФИО'
        ),
        'email' => array (
            'type' => 'text',
            'title' => 'Email',
            'check' => array ('email', 'not_empty'),
            'help_block' => 'На новый email адрес будет выслано письмо с подтверждением операции изменения email',
            'placeholder' => 'Ваш email'
        ),
        'password' => array (
            'type' => 'password',
            'title' => 'Пароль',
            'check' => array ('not_empty'),
            'help_block' => 'Оставьте это поле пустым, если не собираетесь менять пароль',
            'placeholder' => 'Введите новый пароль'
        ),
        'country' => array (
            'type' => 'select',
            'title' => 'Страна',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            ),
            'placeholder' => 'Выберите Вашу страну'
        ),
        'region' => array (
            'type' => 'select',
            'title' => 'Регион',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Region',
                'on' => 'region_id',
                'show' => 'title'
            ),
            'placeholder' => 'Выберите Ваш регион'
        ),
        'city' => array (
            'type' => 'select',
            'title' => 'Город',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'City',
                'on' => 'city_id',
                'show' => 'title'
            ),
            'placeholder' => 'Выберите Ваш город'
        ),
    );
}