<?php
require_once('Models/Base.php');

class User extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';

    public $images = array(
        'small_path' => 'images/userpics/small',
        'upload' => 'images/userpics/big',
        'levels' => 2,
        'w' => 100,
        'h' => 100,
        'maxw' => 500,
        'maxh' => 500
    );

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty')),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password'),
        'type' => array ('type' => 'select', 'title' => 'Тип аккаунта', 'values' => array ('1' => 'Учитель', '2' => 'Ученик')),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email')),
        'fio' => array ('type' => 'text', 'title' => 'Имя', 'check' => array ('not_empty')),
        'zip' => array ('type' => 'text', 'title' => 'Почтовый код'),
        'country' => array (
            'type' => 'select',
            'title' => 'Страна',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'country_id',
                'show' => 'title'
            )
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
            )
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
            )
        ),
        'status' => array (
            'type' => 'select',
            'title' => 'Статус',
            'values' => array ('0' => 'Не активирован', '1' => 'Активирован', '2' => 'Бан')
        ),
        'user_pic' => array ('type' => 'image', 'title' => 'Картинка'),
        'skype' => array ('type' => 'text', 'title' => 'Skype'),
        'use_contact_form' => array ('type' => 'checkbox', 'title' => 'Использовать форму связи'),
        'info' => array ('type' => 'word', 'title' => 'Обо мне'),
    );
}