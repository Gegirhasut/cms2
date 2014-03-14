<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function post () {
        $class = 'Rubric';

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

        $where = null;

        $db = $db->select('r_id as id, title as text')
            ->from($object->table);

        if (!is_null($where)) {
            $db = $db->where($where);
        }

        $records = $db->orderBy('title')->fetch();

        require_once('Helpers/json.php');
        echo arrayToJson($records);
        exit;
    }
    function display () {
        $this->post();
    }
}