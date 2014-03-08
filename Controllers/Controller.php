<?php
require_once('Controllers/SmartyController.php');

class Controller extends SmartyController
{
    function display () {
        $this->smarty->assign('page', 'main');
        parent::display();
    }
}