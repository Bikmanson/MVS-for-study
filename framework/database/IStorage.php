<?php

namespace framework\database;

interface IStorage
{

    public function init();

    public function insert($table, array $fields, array $values);

    public function getData($table);

/*
    public function getField(int $id);
    public function getColumn($columnName);
    public function delete(int $id);
*/
}