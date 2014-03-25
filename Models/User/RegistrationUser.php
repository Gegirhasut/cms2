<?php
require_once('Models/Base.php');

class RegistrationUser extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'fio' => array (
            'type' => 'text',
            'title' => 'ФИО',
            'check' => array ('not_empty'),
            'placeholder' => 'Введите Ваше ФИО',
            'maxlength' => 255
        ),
        'email' => array (
            'type' => 'text',
            'title' => 'Email',
            'check' => array ('email', 'not_empty'),
            'placeholder' => 'Введите email',
            'maxlength' => 255
        ),
        'password' => array (
            'type' => 'password',
            'title' => 'Пароль',
            'check' => array ('not_empty'),
            'placeholder' => 'Введите пароль'
        ),
        'password2' => array (
            'nondb' => 1,
            'type' => 'password',
            'title' => 'Пароль',
            'check' => array ('password2', 'not_empty'),
            'password_field' => 'password',
            'placeholder' => 'Введите пароль еще раз'
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
        'i_am_teacher' => array ('type' => 'checkbox', 'title' => 'Я учитель'),
        'source_id' => array ('type' => 'text', 'title' => 'Номер источника', 'nolist' => 1),
    );
}