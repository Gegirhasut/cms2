<?php
require_once('Models/Base.php');

class SchoolSchoolSubject extends Base
{
    public $table = 'at_school_school_subjects';
    public $identity = 'sss_id';
    public $api_operations = array ('delete' => array ('session_name' => 'school_auth', 'field_name' => 's_id'));

    public $fields = array (
        'sss_id' => array ('type' => 'integer', 'nolist' => 1),
        's_id' => array ('type' => 'select2',
            'title' => 'Школа',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'School',
                'on' => 's_id',
                'show' => 'school_name'
            ),
            'check' => array ('not_empty'),
        ),
        'ss_id' => array ('type' => 'select2',
            'title' => 'Предмет обучения',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'SchoolSubject',
                'on' => 'ss_id',
                'show' => 'subject'
            ),
            'check' => array ('not_empty'),
        ),
    );
}