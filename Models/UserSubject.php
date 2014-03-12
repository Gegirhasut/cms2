<?php
require_once('Models/Base.php');

class UserSubject extends Base
{
    public $table = 'at_user_subjects';
    public $identity = 'us_id';

    public $fields = array (
        'us_id' => array ('type' => 'integer', 'nolist' => 1),
        'u_id' => array ('type' => 'select',
            'title' => 'Пользователь',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'User',
                'on' => 'u_id',
                'show' => 'email'
            ),
            'check' => array ('not_empty'),
        ),
        's_id' => array ('type' => 'select',
            'title' => 'Предмет обучения',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Subject',
                'on' => 's_id',
                'show' => 'subject'
            ),
            'check' => array ('not_empty'),
        ),
        'duration' => array ('type' => 'text', 'title' => 'Длительность', 'check' => array ('not_empty'),),
        'cost' => array ('type' => 'text', 'title' => 'Стоимость', 'check' => array ('not_empty'),),
    );
}