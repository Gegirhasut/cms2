<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function post () {
        $class = Router::$path[0];

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

        $where = '';

        foreach ($_GET as $key => $value) {
            if ($key == 'title' || $key == '_' || $key == 'nosession')
                continue;
            $where .= empty($where) ? $key . ' = ' . (int) $value : ' AND ' . $key . ' = ' . (int) $value;
        }

        if (!empty($_GET['title'])) {
            $value = $_GET['title'];

            $where .= empty($where) ? "title LIKE '" . $db->escape($value) . "%'" : " AND title LIKE '" . $db->escape($value) . "%'";
        }

        $title = 'title';
        if (!is_null($object->select2_field)) {
            $title = $object->select2_field;
        }
        $db = $db->select($object->identity . " as id, $title as text")
            ->from($object->table);

        if (!empty($where)) {
            $db = $db->where($where);
        }

        $records = $db->orderBy('text')->fetch();

        require_once('Helpers/json.php');
        echo arrayToJson($records);
        exit;
    }
    function display () {
        $this->post();
    }
}