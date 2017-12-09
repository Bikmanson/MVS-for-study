<?php

namespace framework\database;

interface IStorage
{

    public static function init();

    public function insert($table, array $fields, array $values);

    public static function find($table);

    public static function update($table, $id, $fieldNames, $nameValues);

    public static function getModelById($table, $id);

    public static function delete($table, $id);
}