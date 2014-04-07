<?php
require_once('Models/Base.php');

class RegistrationSchool extends Base
{
    public $table = 'at_schools';
    public $identity = 's_id';

    public $fields = array (
        's_id' => array ('type' => 'integer', 'nolist' => 1),
        'email' => array ('type' => 'text', 'title' => 'Email', 'check' => array ('email', 'not_empty'), 'placeholder' => 'Введите email',),
        'password' => array ('type' => 'password', 'title' => 'Пароль', 'check' => array ('not_empty'), 'placeholder' => 'Введите пароль',),
        'password2' => array ('nondb' => 1, 'type' => 'password', 'title' => 'Пароль еще раз', 'check' => array ('password2', 'not_empty'), 'password_field' => 'password', 'placeholder' => 'Введите пароль еще раз'),
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
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
            'placeholder' => 'Введите тип обучающего центра',
        ),
        'school_name' => array ('type' => 'text', 'title' => 'Название организации', 'check' => array ('not_empty'), 'placeholder' => 'Введите название обучающего центра'),
        'source_id' => array ('type' => 'text', 'title' => 'Номер источника', 'nolist' => 1),
    );
}