<?php
require_once('Models/Base.php');

class MessagesLog extends Base
{
    public $table = 'at_messages_log';
    public $identity = 'ml_id';

    public $fields = array (
        'ml_id' => array ('type' => 'integer', 'nolist' => 1),
        'm_id' => array('type' => 'text', 'title' => 'ID сообщения'),
        'show_u' => array (
            'type' => 'select',
            'title' => 'Юзер 1',
            'check' => array ('not_empty'),
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'User',
                'on' => 'u_id',
                'show' => 'fio'
            )
        ),
        'is_out' => array ('type' => 'checkbox', 'title' => 'Исходящее?'),
        'another_u' => array (
            'type' => 'select',
            'title' => 'Юзер 2',
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