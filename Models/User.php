<?php

class User
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
        'type' => array ('type' => 'select', 'title' => 'Тип аккаунта', 'values' => array ('1' => 'Учитель', '2' => 'Ученик')),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'unique')),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty')),
        'name' => array ('type' => 'text', 'title' => 'Имя', 'check' => array ('not_empty')),
        'surname' => array ('type' => 'text', 'title' => 'Фамилия'),
        'zip' => array ('type' => 'text', 'title' => 'Почтовый код'),
        'country_id' => array (
            'type' => 'select',
            'title' => 'Страна',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Country',
                'on' => 'c_id',
                'show' => 'country'
            )
        ),
        'city_id' => array (
            'type' => 'select',
            'title' => 'Город',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'City',
                'on' => 'city_id',
                'show' => 'city'
            )
        ),
        'raion' => array ('type' => 'text', 'title' => 'Район'),
        'status' => array ('type' => 'select', 'title' => 'Статус', 'values' => array ('0' => 'Не активирован', '1' => 'Активирован', '2' => 'Бан')),
        'user_pic' => array ('type' => 'image', 'title' => 'Картинка'),
        'skype' => array ('type' => 'text', 'title' => 'Skype'),
        'price' => array ('type' => 'decimal', 'title' => 'Цена 1 часа занятия'),
        'info' => array ('type' => 'word', 'title' => 'Обо мне'),
    );
}