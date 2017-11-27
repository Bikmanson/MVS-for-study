<?php


class DBStorage implements IStorage
{

    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbName = 'php';

    protected static function connect()
    {

        return $db = mysqli_connect(self::$dbHost, self::$dbUsername, '', self::$dbName)
            or die('Trouble with connection database: ' . mysqli_connect_error());

    }

    public function add($table, $field, $value)
    {
        $request = sprintf('INSERT INTO %s (%s) VALUE (%s);', $table, $field, $value);
        mysqli_query($db, $request);
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