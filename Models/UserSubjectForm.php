<?php
require_once('Models/Base.php');

class UserSubjectForm extends Base
{
    public $table = 'at_user_subjects';
    public $identity = 'us_id';

    public $hooks = array (
        'insert' => array (
            'after' => 'InsertSubject'
        ),
        'delete' => array (
            'before' => 'RemoveSubject'
        )
    );

    public $fields = array (
        'us_id' => array ('type' => 'integer', 'nolist' => 1),
        'r_id' => array (
            'type' => 'select2_opt',
            'title' => 'Рубрика',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Rubric',
                'on' => 'r_id',
                'show' => 'title'
            ),
            'relative_fields' => array (
                's_id' => 'enable'
            ),
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
            'placeholder' => 'Выберите рубрику'
        ),
        's_id' => array (
            'type' => 'select2_opt',
            'title' => 'Предмет обучения',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Subject',
                'on' => 's_id',
                'show' => 'subject'
            ),
            'select_fields' => array (
                'r_id' => 'r_id',
            ),
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
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