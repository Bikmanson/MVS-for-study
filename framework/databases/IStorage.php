<?php

interface IStorage
{

    public function insert($table, array $fields, array $values);

    /*
    public function getAll();
    public function getField(int $id);
    public function getColumn($columnName);
    public function delete(int $id);
*/
}