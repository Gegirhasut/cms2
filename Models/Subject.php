<?php
require_once('Models/Base.php');

class Subject extends Base
{
    public $table = 'at_subjects';
    public $identity = 's_id';
    public $api_fields = array('s_id' => 1, 'subject' => 1);

    public $fields = array (
        's_id' => array ('type' => 'integer', 'nolist' => 1),
        'r_id' => array ('type' => 'select',
            'title' => 'Раздел',
            'relation' => array (
                'type' => 'oneToMany',
                'join' => 'Rubric',
                'on' => 'r_id',
                'show' => 'title'
            )
        ),
        'subject' => array ('type' => 'text', 'title' => 'Предмет обучения'),
        'subject_po' => array ('type' => 'text', 'title' => 'Обучает по ...'),
        'cnt' => array ('type' => 'text', 'title' => 'Количество учителей'),
        'url' => array ('type' => 'text', 'title' => 'Ссылка'),
    );
}