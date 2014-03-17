<?php
require_once('Models/Base.php');

class MessageForm extends Base
{
    public $table = 'at_messages';

    public $fields = array (
        'm_id' => array ('type' => 'integer', 'nolist' => 1),
        'message' => array ('type' => 'text', 'title' => 'Сообщение', 'check' => array ('not_empty'), 'placeholder' => 'Введите сообщения для пользователя'),
   );
}