<?php


class DBStorage implements IStorage
{

    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbName = 'php';
    private static $db;

    function __construct()
    {
        return self::$db = mysqli_connect(self::$dbHost, self::$dbUsername, '', self::$dbName)
            or die('Trouble with connection database: ' . mysqli_connect_error());
    }

    public function insert($table, array $fields, array $values)
    {
        $fields = implode(", ", $fields);
        $values = "'" . implode("','", $values) . "'";

        $request = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $fields, $values);
        mysqli_query(self::$db, $request);
    }

/*
    public function getAll()
    {

    }

    public function getField($fieldName)
    {
    }

    public function getElement(int $id)
    {
    }

    public function delete(int $id)
    {
    }
*/
}