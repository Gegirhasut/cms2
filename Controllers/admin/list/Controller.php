<?php
require_once ('Controllers/admin/BaseAdminController.php');
require_once ('Database/DBFactory.php');

class Controller extends BaseAdminController
{
    public $show_on_page = 10;

    protected function getPages($records_count, $show_on_page) {
        $pages = (int) ($records_count / $show_on_page);
        if ($pages * $show_on_page < $records_count) {
            $pages++;
        }

        return $pages;
    }

    protected function makeSorting ($class) {
        if (isset($_GET['order'])) {
            $direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';

            $_SESSION[$class]['order'] = array(
                'by' => $_GET['order'],
                'direction' => $direction
            );

            header('location: ' . $_SERVER['REDIRECT_URL']);
            exit;
        }
    }

    protected function getRelationValues($object, &$records) {
        $relationValues = array ();

        foreach ($records as &$record) {
            foreach ($object->fields as $field => &$field_properties) {
                if (isset($field_properties['relation'])) {
                    switch ($field_properties['relation']['type']) {
                        case 'oneToMany':
                            if (!isset($relationValues[$field])) {
                                $relationValues[$field] = array($record[$field] => $record[$field]);
                            } else {
                                $relationValues[$field][$record[$field]] = $record[$field];
                            }
                            break;
                    }
                }
            }
        }

        return $relationValues;
    }

    protected function setValues($object, &$records) {
        $relationValues = $this->getRelationValues($object, $records);

        foreach ($records as &$record) {
            foreach ($object->fields as $field => &$field_properties) {
                switch ($field_properties['type']) {
                    case 'select':
                        if (!isset($field_properties['values']) && isset($relationValues[$field])) {
                            require_once('Models/' . $field_properties['relation']['join'] . '.php');
                            $join = new ReflectionClass($field_properties['relation']['join']);
                            $join = $join->newInstance();

                            $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);
                            $relObjects = $db = $db->select($field_properties['relation']['on'] . ',' . $field_properties['relation']['show'])
                                ->from($join->table)
                                ->where($field_properties['relation']['on'] . ' in (' . implode(',', $relationValues[$field]) . ')')
                                ->fetch($field_properties['relation']['on'], $field_properties['relation']['show']);

                            $field_properties['values'] = $relObjects;
                        }

                        if (isset($field_properties['values'])) {
                            if (isset($field_properties['values'][$record[$field]])) {
                                $record[$field] = $field_properties['values'][$record[$field]];
                            }
                        }
                        break;
                }
            }
        }
    }

    function display () {
        if (empty(Router::$path)) {
            header('location: /admin/');
            exit;
        }

        $class = Router::$path[0];
        require_once('Models/' . $class . '.php');
        $object = new ReflectionClass($class);
        $object = $object->newInstance();

        $this->makeSorting($class);

        /**
         * var MySQL
         */
        $db = DBFactory::getInstance('mysql', $GLOBALS['mysql']);

        $db = $db->select('SQL_CALC_FOUND_ROWS *')
            ->from($object->table);

        if (isset($_SESSION[$class]['order'])) {
            $db = $db->orderBy($_SESSION[$class]['order']['by'], $_SESSION[$class]['order']['direction']);
        } else {
            $db = $db->orderBy($object->identity);
        }

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $result = $db->limit(($page - 1) * $this->show_on_page   , $this->show_on_page)
            ->fetch();

        $records_count = $db->count();
        $pages = $this->getPages($records_count, $this->show_on_page);

        $this->setValues($object, $result);

        $this->smarty->assign('data', $result);
        $this->smarty->assign('object', $object);
        $this->smarty->assign('identity', $object->identity);
        $this->smarty->assign('class', $class);
        $this->smarty->assign('page', 'list');
        $this->smarty->assign('pagesCount', $pages);
        $this->smarty->assign('currentPage', $page);

        parent::display();
    }
}