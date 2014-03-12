<?php
require_once('Models/Base.php');

class UserSubjectForm extends Base
{
    public $table = 'at_user_subjects';
    public $identity = 'us_id';

    public $fields = array (
        'us_id' => array ('type' => 'integer', 'nolist' => 1),
        'r_id' => array (
            'type' => 'select',
            'title' => 'Рубрика',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Rubric',
                'on' => 'r_id',
                'show' => 'title'
            ),
            'placeholder' => 'Выберите рубрику'
        ),
        's_id' => array (
            'type' => 'select',
            'title' => 'Предмет обучения',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Subject',
                'on' => 's_id',
                'show' => 'subject'
            ),
            'placeholder' => 'Выберите предмет'
        ),
        'duration' => array (
            'type' => 'text',
            'title' => 'Длительность',
            'placeholder' => 'Длительность урока в минутах'
        ),
        'cost' => array (
            'type' => 'text',
            'title' => 'Стоимость',
            'placeholder' => 'Стоимость обучения в рублях'
        ),
    );
}