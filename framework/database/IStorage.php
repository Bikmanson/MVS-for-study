<?php

namespace framework\database;

interface IStorage
{

    public static function init();

    public function insert($table, array $fields, array $values);

    public static function find($table);

    public function getById($id);

/*
    public function getColumn($columnName);
    public function delete(int $id);
*/
}