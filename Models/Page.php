<?php
require_once('Models/Base.php');

class Page extends Base
{
    public $table = 'at_pages';
    public $identity = 's_id';
    public $api_fields = array('s_id' => 1, 'subject' => 1);

    public $fields = array (
        's_id' => array ('type' => 'integer', 'nolist' => 1),
        'title' => array ('type' => 'text', 'title' => 'Заголовок в браузере'),
        'description' => array ('type' => 'text', 'title' => 'Описание в браузере'),
        'keywords' => array ('type' => 'text', 'title' => 'Ключевые слова в браузере'),
        'url' => array ('type' => 'text', 'title' => 'Ссылка'),
        'text' => array ('type' => 'word', 'title' => 'Текст', 'rows' => 24),
    );
}