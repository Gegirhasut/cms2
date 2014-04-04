<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function display () {
        if (count(Router::$path) < 2) {
            echo '0';
            exit;
        }

        $class = Router::$path[1];

        $identity = (int) Router::$path[0];

        Application::requireClass($class);
        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        if (!isset($object->api_operations)) {
            echo '0';
            exit;
        }

        if (!isset($object->api_operations['delete'])) {
            echo '0';
            exit;
        }

        if (!isset($_SESSION[$object->api_operations['delete']['session_name']])) {
            echo '0';
            exit;
        }

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $where = $object->identity . ' = ' . $identity;

        $where .= ' AND ' . $object->api_operations['delete']['field_name'] . ' = ' . $_SESSION[$object->api_operations['delete']['session_name']][$object->api_operations['delete']['field_name']];

        $object->{$object->identity} = $identity;

        $db->delete($object)
            ->where($where)
            ->execute();

        echo $identity;
    }
}