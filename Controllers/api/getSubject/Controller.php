<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function post () {
        $class = 'Subject';

        if (!Application::requireClass($class)) {
            throw new Exception("Unable to use API. Wrong Object [$class]. Request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        if (!isset($object->api_fields)) {
            throw new Exception("Unable to use API for object [$class]. No [$class -> api_fields] support defined");
            exit;
        }

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $where = 'r_id = ' . (int) $_GET['r_id'];

        $db = $db->select('s_id as id, subject as text')
            ->from($object->table);

        $db = $db->where($where);

        $records = $db->orderBy('subject')->fetch();

        require_once('Helpers/json.php');
        echo arrayToJson($records);
        exit;
    }
    function display () {
        $this->post();
    }
}