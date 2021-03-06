<?php
require_once('Application/AdminSecurity.php');
class BaseAdminController
{
    protected $smarty = null;

    public function __construct () {
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
                'Пользователи/Организации' => array ('dropdown' =>
                    array(
                        'Пользователи' => array ('url' => '/admin/list/User/?order=u_id&by=desc'),
                        'Активации' => array ('url' => '/admin/list/Activation/?order=a_id'),
                        'Смена емайла' => array ('url' => '/admin/list/ChangeEmail/?order=ce_id'),
                        'Восстановление пароля' => array ('url' => '/admin/list/RemindPassword/?order=rp_id'),
                        'Школы' => array ('url' => '/admin/list/School/?order=s_id&by=desc'),
                        'Школа - Адресс' => array ('url' => '/admin/list/SchoolAddress/'),
                        'Активации школ' => array ('url' => '/admin/list/SchoolActivation/?order=sa_id'),
                        'Смена емайла для школ' => array ('url' => '/admin/list/ChangeEmailSchool/?order=ces_id'),
                        'Восстановление пароля школ' => array ('url' => '/admin/list/RemindPasswordSchool/?order=rps_id'),
                        'Источники' => array ('url' => '/admin/list/RegSource/?order=rs_id&by=desc')
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
                        'Типы школ' => array ('url' => '/admin/list/SchoolRubric/'),
                        'Направление в школе' => array ('url' => '/admin/list/SchoolSubject/'),
                        'Школа - направление' => array ('url' => '/admin/list/SchoolSchoolSubject/'),
                    )
                ),
                'Сайт' => array ('dropdown' =>
                    array(
                        'Разделы сайта' => array ('url' => '/admin/list/Page/'),
                    )
                ),
                'Сообщения' => array ('url' => '/admin/list/Message/'),
            );

            $this->smarty->assign('menu', $admin_menu);
        }

        $this->smarty->display('admin/main.tpl');
    }
}