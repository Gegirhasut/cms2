<?php

interface IDatabase {
    public function connect ($params);
    public function execute ();
    public function fetch ($id = null);

    /**
     * @return IDatabase
     */
    public function delete ();
    /**
     * @return IDatabase
     */
    public function count ();
    /**
     * @param $field
     * @return IDatabase
     */
    public function select ($field);
    /**
     * @param $field
     * @return IDatabase
     */
    public function from ($table);
    /**
     * @param $condition
     * @return IDatabase
     */
    public function where ($condition);
    /**
     * @param $table
     * @param $on
     * @return IDatabase
     */
    public function join ($table, $on);
    /**
     * @param $table
     * @param $on
     * @return IDatabase
     */
    public function leftJoin ($table, $on);
    /**
     * @param $table
     * @param $on
     * @return IDatabase
     */
    public function rightJoin ($table, $on);
    /**
     * @param $offset
     * @param $limit
     * @return IDatabase
     */
    public function limit ($offset, $limit);
    /**
     * @param $by
     * @param $direction
     * @return IDatabase
     */
    public function orderBy ($by, $direction = 'ASC');

    /**
     * @param $object
     * @param bool $ignore
     * @return IDatabase
     */
    public function insert ($object, $ignore = false);

    /**
     * @param $object
     * @return IDatabase
     */
    public function update ($object);

    public function lastId();
}