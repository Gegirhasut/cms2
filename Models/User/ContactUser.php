<?php
require_once('Models/Base.php');

class ContactUser extends Base
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
        'skype' => array ('type' => 'text', 'title' => 'Skype', 'placeholder' => 'Ваш skype', 'maxlength' => 100),
        'info' => array (
            'type' => 'word',
            'title' => 'Дополнительная информация',
            'placeholder' => 'Введите дополнительную информацию о Вас',
        ),
        //'use_contact_form' => array ('type' => 'checkbox', 'title' => 'Использовать форму связи'),
        'user_pic' => array ('type' => 'image', 'title' => 'Мини-фото', 'placeholder' => 'Рекомендуем загрузить мини-фото.<br>1. Нажмите кнопку "Выбрать файл".<br>2. Выберите файл с диска.<br>3. Нажмите кнопку "Загрузить картинку".<br>4. Выбирите область для создания миниатюры.'),
    );
}