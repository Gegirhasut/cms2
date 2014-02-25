<?php
class Controller
{
    function display () {
        require_once('Application/SmartyLoader.php');
        $smarty = SmartyLoader::getSmarty();
        $smarty->caching = false;

        $smarty->display('main.tpl');
    }
}