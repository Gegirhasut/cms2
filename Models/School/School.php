<?php
require_once('Models/Base.php');

class School extends Base
{
    public $table = 'at_schools';
    public $identity = 's_id';
    public $api_fields = array('s_id' => 1, 'school_name' => 1);

    public $hooks = array (
        'update' => array (
            'before' => 'UpdateSchool_SaveImage',
            'after' => 'UpdateSchool_RemoveImage'
        )
    );

    public $images = array(
        'small_path' => 'images/banners/small',
        'upload' => 'images/banners/big',
        'session_name' => 'school_auth',
        'redirect_url' => '/school/login',
        'levels' => 2,
        'w' => 150,
        'h' => 150,
        'maxw' => 800,
        'maxh' => 800
    );

    public $fields = array (
        's_id' => array ('type' => 'integer', 'nolist' => 1),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty')),
        'sr_id' => array (
            'type' => 'select2',
            'title' => 'Тип организации',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'SchoolRubric',
                'on' => 'sr_id',
                'show' => 'title'
            )
        ),
        'school_name' => array ('type' => 'text', 'title' => 'Название организации', 'check' => array ('not_empty')),
        'status' => array (
            'type' => 'select',
            'title' => 'Статус',
            'values' => array ('0' => 'Не активирован', '1' => 'Активирован', '2' => 'Бан')
        ),
        'banner' => array ('type' => 'image', 'title' => 'Картинка'),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty')),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password'),
        'website' => array ('type' => 'text', 'title' => 'Вебсайт', 'check' => array ('website')),
        'info' => array ('type' => 'word', 'title' => 'Обо мне'),
        'source_id' => array ('type' => 'generated', 'title' => 'Номер источника', 'default' => "NULL"),
    );
}