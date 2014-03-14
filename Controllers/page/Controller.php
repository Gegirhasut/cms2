<?php
require_once('Controllers/SmartyController.php');
require_once ('Database/DBFactory.php');

class Controller extends SmartyController
{
    public $user_auth = false;
    public $db = null;

    function __construct() {
        /**
         * var MySQL
         */

        $this->db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
        parent::__construct();
    }

    function display () {
        Application::requireClass('Page');
        $page = new Page();
        $pageUrl = Router::$path[0];
        if (empty($pageUrl)) {
            throw new Exception404();
        }
        $pages = $this->db->select()->from($page->table)->where("url = '$pageUrl'")->fetch();
        if (empty($pages)) {
            throw new Exception404();
        }

        $this->smarty->assign('title', $pages[0]['title']);
        $this->smarty->assign('description', $pages[0]['description']);
        $this->smarty->assign('keywords', $pages[0]['keywords']);
        $this->smarty->assign('text', $pages[0]['text']);

        $this->smarty->assign('page', 'page');

        parent::display();
    }
}