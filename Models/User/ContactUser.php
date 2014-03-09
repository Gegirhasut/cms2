<?php
require_once('Models/Base.php');

class ContactUser extends Base
{
    public $table = 'at_users';
    public $identity = 'u_id';

    public $fields = array (
        'u_id' => array ('type' => 'integer', 'nolist' => 1),
        'skype' => array ('type' => 'text', 'title' => 'Skype', 'placeholder' => 'Ваш skype'),
        'info' => array (
            'type' => 'word',
            'title' => 'Дополнительная информация',
            'placeholder' => 'Введите дополнительную информацию о Вас'
        ),
        'use_contact_form' => array ('type' => 'checkbox', 'title' => 'Использовать форму связи'),
    );
}