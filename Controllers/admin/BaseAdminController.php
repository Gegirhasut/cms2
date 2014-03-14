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
                'Пользователи' => array ('dropdown' =>
                    array(
                        'Пользователи' => array ('url' => '/admin/list/User/?order=u_id'),
                        'Активации' => array ('url' => '/admin/list/Activation/?order=a_id'),
                        'Смена емайла' => array ('url' => '/admin/list/ChangeEmail/?order=ce_id'),
                        'Восстановление пароля' => array ('url' => '/admin/list/RemindPassword/?order=rp_id')
                    )
                ),
                'География' => array ('dropdown' =>
                    array(
                        'Страны' => array ('url' => '/admin/list/Country/'),
                        'Регионы' => array ('url' => '/admin/list/Region/'),
                        'Города' => array ('url' => '/admin/list/City/'),
                    )
                ),
                'Обучение' => array ('dropdown' =>
                    array(
                        'Рубрики' => array ('url' => '/admin/list/Rubric/'),
                        'Предметы' => array ('url' => '/admin/list/Subject/'),
                        'Пользователь - Предметы' => array ('url' => '/admin/list/UserSubject/'),
                    )
                ),
                'Сайт' => array ('dropdown' =>
                    array(
                        'Разделы сайта' => array ('url' => '/admin/list/Page/'),
                    )
                ),
            );

            $this->smarty->assign('menu', $admin_menu);
        }

        $this->smarty->display('admin/main.tpl');
    }
}