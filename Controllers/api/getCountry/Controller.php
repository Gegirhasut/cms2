<?php
require_once ('Database/DBFactory.php');

class Controller
{
    function post () {
        if (empty($_GET['title'])) {
            exit;
        }
        $class = 'Country';

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

        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                if ($key == 'debug' || $key == '_') {
                    continue;
                }

                if (!isset($object->fields[$key])) {
                    throw new Exception("Wrong field usage in API for object [$class -> $key]");
                    exit;
                }

                if (is_null($where)) {
                    $where = "$key LIKE '" . $db->escape($value) . "%'";
                } else {
                    $where .= " AND $key LIKE '" . $db->escape($value) . "%'";
                }
            }
        }

        $db = $db->select('country_id as id, title as text')
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