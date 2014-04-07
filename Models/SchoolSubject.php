<?php
require_once('Models/Base.php');

class SchoolSubject extends Base
{
    public $table = 'at_school_subjects';
    public $identity = 'ss_id';
    public $api_fields = array('ss_id' => 1, 'subject' => 1);
    public $select2_field = 'subject';

    public $fields = array (
        'ss_id' => array ('type' => 'integer', 'nolist' => 1),
        'sr_id' => array ('type' => 'select2',
            'title' => 'Раздел',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'SchoolRubric',
                'on' => 'sr_id',
                'show' => 'title'
            )
        ),
        'subject' => array ('type' => 'text', 'title' => 'Направление обучения'),
        'subject_po' => array ('type' => 'text', 'title' => 'Обучает по ...'),
        'url' => array ('type' => 'text', 'title' => 'Ссылка'),
    );
}