<?php
require_once('Models/Base.php');

class Country extends Base
{
    public $table = 'countries';
    public $identity = 'country_id';
    public $api_fields = array('country_id' => 1, 'title' => 1);

    public $fields = array (
        'country_id' => array ('type' => 'integer', 'nolist' => 1),
        'title' => array ('type' => 'text', 'title' => 'Страна'),
    );
}