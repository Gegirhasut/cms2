<?php
require_once('Application/AdminSecurity.php');
class BaseAdminController
{
    protected $smarty = null;

    public function __construct () {
        session_start();

        AdminSecurity::checkAdmin();

        if (isset(Router::$path[0])) {
            $this->object = Router::$path[0];
        }

        require_once('Application/SmartyLoader.php');
        $this->smarty = SmartyLoader::getSmarty();
        $this->smarty->caching = false;
        $this->smarty->assign('page', 'main'); // Can be overloaded
    }

    function display($menu = true) {
        if ($menu) {
            $admin_menu = array (
                'Пользователи' => array ('url' => '/admin/list/User/?order=u_id', 'object' => 'User'),
                'География' => array ('dropdown' =>
                    array(
                        'Страны' => array ('url' => '/admin/list/Country/', 'object' => 'Subject'),
                        'Города' => array ('url' => '/admin/list/City/', 'object' => 'Rubric'),
                    )
                ),
                'Предметы' => array ('dropdown' =>
                    array(
                        'Рубрики' => array ('url' => '/admin/list/Rubric/', 'object' => 'Rubric'),
                        'Предметы' => array ('url' => '/admin/list/Subject/', 'object' => 'Subject'),
                    )
                ),
            );

            $this->smarty->assign('menu', $admin_menu);
        }

        $this->smarty->display('admin/main.tpl');
    }
}