<?php
require_once ('Controllers/admin/BaseAdminController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseAdminController
{
    protected $object = null;
    protected $class = null;
    protected $id = null;

    function detectObject() {
        if (empty(Router::$path)) {
            header('location: /admin/');
            exit;
        }

        if (count(Router::$path) == 1) {
            $this->class = Router::$path[0];
        } else {
            $this->class = Router::$path[1];
            $this->id = Router::$path[0];
        }

        require_once('Models/' . $this->class . '.php');
        $this->object = new ReflectionClass($this->class);
        $this->object = $this->object->newInstance();
    }

    function post() {
        $this->detectObject();
        require_once('helpers/ObjectParser.php');
        ObjectParser::parse($_POST, $this->object);

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        if (!isset($this->object->fields[$this->object->identity]['value'])) {
            $db->insert($this->object)->execute();
        } else {
            $db->update($this->object)->execute();
        }
    }

    function getObject($id, $object) {
        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $records = $db = $db->select('*')
            ->from($object->table)
            ->where($object->identity . ' = ' . $id)
            ->fetch();

        if (!empty($records)) {
            $this->setValues($object, $records[0]);
            $this->smarty->assign('values', $records[0]);
        }
    }

    protected function setValues($object, &$record) {
        $select_values = array ();
        foreach ($object->fields as $field => &$field_properties) {
            switch ($field_properties['type']) {
                case 'select':
                    if (isset($field_properties['relation']) && !empty($record[$field])) {
                        require_once('Models/' . $field_properties['relation']['join'] . '.php');
                        $join = new ReflectionClass($field_properties['relation']['join']);
                        $join = $join->newInstance();

                        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
                        $relObjects = $db = $db->select($field_properties['relation']['show'])
                            ->from($join->table)
                            ->where($field_properties['relation']['on'] . ' = ' . $record[$field])
                            ->fetch(null, $field_properties['relation']['show']);

                        $select_values[$field] = $relObjects[0][$field_properties['relation']['show']];

                    }
                    break;
            }
        }

        $this->smarty->assign('select_values', $select_values);
    }

    function display () {
        $this->detectObject();

        if (!is_null($this->id)) {
            $this->getObject($this->id, $this->object);
        } else {
            $this->smarty->assign('add_new', 1);
        }

        $this->smarty->assign('object', $this->object);
        $this->smarty->assign('identity', $this->object->identity);
        $this->smarty->assign('class', $this->class);
        $this->smarty->assign('page', 'record');

        parent::display(false);
    }
}