<?php

class DBFactory {
    /**
     * @param $type
     * @return IDatabase
     */
    public static function getInstance($type, $params) {
        switch ($type) {
            case 'mysql':
                require_once('MySQL.php');
                $mysql = new MySQL();
                $mysql->connect($params);
                return $mysql;
        }
    }
}