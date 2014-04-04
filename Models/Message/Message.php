<?php
require_once('Models/Base.php');

class Message extends Base
{
    public $table = 'at_messages';
    public $identity = 'm_id';

    public $fields = array (
        'm_id' => array ('type' => 'integer', 'nolist' => 1),
        'subject' => array ('type' => 'text', 'title' => 'Тема', 'check' => array ('not_empty'), 'placeholder' => 'Введите тему сообщения'),
        'message' => array ('type' => 'text', 'title' => 'Сообщение', 'check' => array ('not_empty'), 'placeholder' => 'Введите сообщения для пользователя'),
        'u_id_from' => array (
            'type' => 'select2',
            'title' => 'Сообщение от',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'User',
                'on' => 'u_id',
                'show' => 'fio'
            )
        ),
        'u_id_to' => array (
            'type' => 'select2',
            'title' => 'Сообщение к',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'User',
                'on' => 'u_id',
                'show' => 'fio'
            )
        )
   );
}