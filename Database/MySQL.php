<?php
require_once('IDatabase.php');

class MySQL implements IDatabase
{
    /**
     * @var mysqli
     */
    public $mysqli = null;

    protected $union = false;

    public function connect ($params) {
        if (!is_null($this->mysqli)) {
            return $this->mysqli;
        }

        if (!isset($params['port'])) {
            $params['port'] = 3306;
        }
        $this->mysqli = mysqli_connect($params['host'], $params['user'], $params['password'], $params['database'], $params['port']);

        if ($this->mysqli->connect_errno) {
            throw new Exception("Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error);
        }

        return $this->mysqli;
    }

    public function execute () {
        $result = $this->mysqli->query($this->sql);

        if (!$result) {
            throw new Exception('Error executing SQL query : ' . $this->sql . '. Error: ' . $this->mysqli->error);
        }
    }

    public function fetch ($id = null, $field = null) {
        if (strpos($this->sql, 'UNION') !== false) {
            $this->sql = '(' . $this->sql . ')';
        }

        if (isset($_GET['debug'])) {
            echo $this->sql . "<br>";
        }
        $result = $this->mysqli->query($this->sql);
        if (!$result) {
            throw new Exception('Error executing SQL query : ' . $this->sql . '. Error: ' . $this->mysqli->error);
        }

        $rows = array ();
        while ($row = $result->fetch_assoc()) {
            if (is_null($id)) {
                $rows[] = $row;
            } else {
                if (is_null($field)) {
                    $rows[$row[$id]] = $row;
                } else {
                    $rows[$row[$id]] = $row[$field];
                }
            }
        }

        $result->close();

        return $rows;
    }

    protected $sql = '';

    public function delete () {
        $this->sql = "DELETE ";
        return $this;
    }

    public function select ($field = '*') {
        if ($this->union) {
            $this->union = false;
            $this->sql .= ") UNION (SELECT $field ";
        } else {
            $this->sql = "SELECT $field ";
        }
        return $this;
    }
    public function from ($table) {
        $this->sql .= 'FROM ' . $table;
        return $this;
    }
    public function where ($condition) {
        $this->sql .= ' WHERE ' . $condition;
        return $this;
    }
    public function join ($table, $on) {
        $this->sql .= ' JOIN ' . $table . ' ' . $on;
        return $this;
    }
    public function leftJoin ($table, $on) {
        $this->sql .= ' LEFT JOIN ' . $table . ' ' . $on;
        return $this;
    }
    public function rightJoin ($table, $on) {
        $this->sql .= ' RIGHT JOIN ' . $table . ' ' . $on;
        return $this;
    }

    public function limit ($offset, $limit) {
        $this->sql .= " LIMIT $offset, $limit";
        return $this;
    }

    public function orderBy ($by, $direction = 'ASC') {
        $this->sql .= " ORDER BY $by $direction";
        return $this;
    }

    public function insert ($object, $ignore = false) {
        if ($ignore) {
            $this->sql = 'INSERT IGNORE INTO ' . $object->table;
        } else {
            $this->sql = 'INSERT INTO ' . $object->table;
        }

        $columns = '';
        $values = '';

        foreach ($object->fields as $key => $field) {
            if (isset($field['nondb'])) {
                continue;
            }
            if (isset($field['value'])) {
                $columns .= empty($columns) ? '(' . $key : ',' . $key;
                $values .= empty($values) ? '(' . "'" . $this->mysqli->real_escape_string($field['value']) . "'" : ", '" . $this->mysqli->real_escape_string($field['value']) . "'";
            }
        }

        $columns .= ')';
        $values .= ')';

        $this->sql .= " $columns VALUES $values";

        return $this;
    }

    public function update ($object) {
        $update = '';

        foreach ($object->fields as $key => $field) {
            if (isset($field['value']) && $key != $object->identity) {
                if (!empty($update)) {
                    $update = $update . ', ';
                }
                $update .= "$key ='" . $this->mysqli->real_escape_string($field['value']) . "'";
            }
        }

        $this->sql = "UPDATE {$object->table} SET $update WHERE {$object->identity} = " . $object->fields[$object->identity]['value'];

        return $this;
    }

    public function union () {
        $this->union = true;

        return $this;
    }

    public function escape ($string) {
        return $this->mysqli->real_escape_string($string);
    }

    public function count() {
        $res = $this->select('FOUND_ROWS() as cnt')->fetch();
        return $res[0]['cnt'];
    }

    public function lastId() {
        return $this->mysqli->insert_id;
    }
}