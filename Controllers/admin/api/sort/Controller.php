<?php
require_once ('Database/DBFactory.php');
require_once ('Controllers/admin/api/BaseApiController.php');

class Controller extends BaseApiController
{
    function display () {
        if (!isset($_GET['order'])) {
            throw new Exception("Unable to use API. No sort order defined.");
            exit;
        }

        if (count(Router::$path) < 1) {
            throw new Exception("Unable to use API. No object defined, wrong request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $class = Router::$path[0];

        if (!Application::requireClass($class)) {
            throw new Exception("Unable to use API. Wrong Object [$class]. Request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $ids = explode(',', $_GET['order']);
        $sortField = $object->sort;
        $sortOrder = 1;
        foreach ($ids as $id) {
            $object->{$object->identity} = $id;
            $object->fields[$sortField]['value'] = $sortOrder++;
            $db->update($object)->execute();
        }
    }
}