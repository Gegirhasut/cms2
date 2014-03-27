<?php
require_once('Models/Base.php');

class User extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';
    public $api_fields = array('u_id' => 1, 'email' => 1);

    public $hooks = array (
        'update' => array (
            'before' => 'UpdateUser_SaveImage',
            'after' => 'UpdateUser_RemoveImage'
        )
    );

    public $images = array(
        'small_path' => 'images/userpics/small',
        'upload' => 'images/userpics/big',
        'levels' => 2,
        'w' => 150,
        'h' => 150,
        'maxw' => 800,
        'maxh' => 800
    );

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty')),
        'fio' => array ('type' => 'text', 'title' => 'Имя', 'check' => array ('not_empty')),
        'i_am_teacher' => array ('type' => 'checkbox', 'title' => 'Учитель'),
        'subjects' => array ('type' => 'int', 'title' => 'Количество предметов'),
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
            'require' => array (
                'name' => 'country_id',
                'id' => 'country_id'
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
                'show' => 'title',
            ),
            'require' => array (
                'name' => 'region_id',
                'id' => 'region_id'
            )
        ),
        'status' => array (
            'type' => 'select',
            'title' => 'Статус',
            'values' => array ('0' => 'Не активирован', '1' => 'Активирован', '2' => 'Бан')
        ),
        'user_pic' => array ('type' => 'image', 'title' => 'Картинка'),
        'skype' => array ('type' => 'text', 'title' => 'Skype'),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty')),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password'),
        //'use_contact_form' => array ('type' => 'checkbox', 'title' => 'Использовать форму связи'),
        'info' => array ('type' => 'word', 'title' => 'Обо мне'),
        'messages' => array ('type' => 'integer', 'title' => 'Количество непрочитанных сообщений', 'default' => 0),
        'last_login' => array ('type' => 'generated', 'title' => 'Последний вход'),
        'source_id' => array ('type' => 'generated', 'title' => 'Номер источника', 'default' => "NULL"),
    );
}