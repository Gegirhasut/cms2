<?php
class SmartyLoader {
    public static function getSmarty() {
        require_once ('Libs/Smarty/Smarty.class.php');
        $smarty = new Smarty();
        $smarty->template_dir = 'Html/templates';
        $smarty->compile_dir   = 'Html/templates_c';
        $smarty->cache_dir = 'Html/cache';
        $smarty->caching = true;

        return $smarty;
    }
}