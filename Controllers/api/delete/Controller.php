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

        require_once('Models/' . $class . '.php');
        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $db->delete()
            ->from($object->table)
            ->where($object->identity . ' = ' . $identity)
            ->execute();

        echo '1';
    }
}