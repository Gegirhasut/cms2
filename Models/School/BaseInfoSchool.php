<?php
require_once('Models/Base.php');

class BaseInfoSchool extends Base
{
    public $table = 'at_schools';
    public $identity = 's_id';
    public $api_fields = array('s_id' => 1, 'email' => 1);

    public $hooks = array (
        'update' => array (
            'before' => 'UpdateSchool_SaveImage',
            'after' => 'UpdateSchool_RemoveImage'
        )
    );

    public $images = array(
        'small_path' => 'images/banners/small',
        'upload' => 'images/banners/big',
        'levels' => 2,
        'w' => 150,
        'h' => 150,
        'maxw' => 800,
        'maxh' => 800
    );

    public $fields = array (
        's_id' => array ('type' => 'integer', 'nolist' => 1),
        'email' => array (
            'type' => 'text',
            'title' => 'Email',
            'check' => array ('email', 'not_empty'),
            'help_block' => 'На новый email адрес будет выслано письмо с подтверждением операции изменения email',
            'placeholder' => 'Ваш email',
            'maxlength' => 255
        ),
        'sr_id' => array (
            'type' => 'select2',
            'title' => 'Тип организации',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'SchoolRubric',
                'on' => 'sr_id',
                'show' => 'title'
            ),
            'placeholder' => 'Выберите тип организации',
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
        ),
        'school_name' => array (
            'type' => 'text',
            'title' => 'Название организации',
            'check' => array ('not_empty'),
            'placeholder' => 'Название организации',
            'maxlength' => 255
        ),
        'password' => array (
            'type' => 'password',
            'title' => 'Пароль',
            'check' => array ('not_empty'),
            'help_block' => 'Оставьте это поле пустым, если не собираетесь менять пароль',
            'placeholder' => 'Введите новый пароль',
        ),
        'website' => array (
            'type' => 'text',
            'title' => 'Вебсайт',
            'check' => array ('website'),
            'placeholder' => 'http://example.com',
        ),
        'info' => array (
            'type' => 'word',
            'title' => 'Информация',
            'placeholder' => 'Введите дополнительную информацию об организации',
            'width' => 10
        ),
        'banner' => array (
            'type' => 'image',
            'title' => 'Баннер',
            'placeholder' => 'Рекомендуем загрузить баннер.<br>1. Нажмите кнопку "Выбрать файл".<br>2. Выберите файл с диска.<br>3. Нажмите кнопку "Загрузить картинку".<br>4. Выбирите область для создания миниатюры.'
        ),
    );
}