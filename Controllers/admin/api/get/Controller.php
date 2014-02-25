<?php
require_once ('Database/DBFactory.php');
require_once ('Controllers/admin/api/BaseApiController.php');

class Controller extends BaseApiController
{
    function post () {
        if (count(Router::$path) < 1) {
            throw new Exception("Unable to use API. No object defined, wrong request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $class = Router::$path[0];

        if (!file_exists('Models/' . $class . '.php')) {
            throw new Exception("Unable to use API. Wrong Object [$class]. Request: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        require_once('Models/' . $class . '.php');
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

        $fields = '*';

        /**
         * JOPARDY!!!
         * Можно в fields пепредать SQL injection!
         */
        if (isset($_POST['fields'])) {
            $fields = $_POST['fields'];
            if (!empty($object->api_fields)) {
                $fieldsAr = explode(',', $fields);
                foreach ($fieldsAr as $key) {
                    if (!isset($object->api_fields[$key])) {
                        throw new Exception("Wrong field usage in API for object [$class -> $key]. $key is stricted in api_fields.");
                        exit;
                    }
                }
            }

        } else {
            if (!empty($object->api_fields)) {
                throw new Exception("Wrong field usage in API for object [$class]. * is stricted.");
                exit;
            }
        }

        $where = null;

        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                if ($key == 'debug') {
                    continue;
                }

                $operator = '=';
                if (substr($value, -1) == '%') {
                    $operator = 'LIKE';
                }

                if (!isset($object->fields[$key])) {
                    throw new Exception("Wrong field usage in API for object [$class -> $key]");
                    exit;
                }

                if (is_null($where)) {
                    $where = "$key $operator '" . $db->escape($value) . "'";
                } else {
                    $where .= " AND $key $operator '" . $db->escape($value) . "'";
                }
            }
        }

        $db = $db->select($fields)
            ->from($object->table);
        if (!is_null($where)) {
            $db = $db->where($where);
        }

        $records = $db->fetch();

        require_once('Helpers/json.php');
        echo arrayToJson($records);
        exit;
    }
    function display () {
        $this->post();
    }
}