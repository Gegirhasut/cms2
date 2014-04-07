<?php
require_once('Models/Base.php');

class SchoolSubjectForm extends Base
{
    public $table = 'at_school_school_subjects';
    public $identity = 'sss_id';

    public $fields = array (
        'sss_id' => array ('type' => 'integer', 'nolist' => 1),
        'sr_id' => array ('type' => 'hidden'),
        'ss_id' => array (
            'type' => 'select2_opt',
            'title' => 'Предмет обучения',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'SchoolSubject',
                'on' => 'ss_id',
                'show' => 'subject'
            ),
            'select_fields' => array (
                'sr_id' => 'sr_id',
            ),
            'minimumInputLength' => 0,
            'maxSearchLetters' => 0,
            'placeholder' => 'Выберите предмет'
        ),
    );
}