<?php


class DBStorage implements IStorage
{
    private static $config;
    private static $db;

// connecting with database
    public function init()
    {
        self::$config = [
            'host' => Application::getConfig()['storage']['host'],
            'user' => Application::getConfig()['storage']['user'],
            'password' => Application::getConfig()['storage']['password'],
            'database' => Application::getConfig()['storage']['database']
        ];
        if (!self::$config['password']) {
            self::$config['password'] = '';
        }

        return self::$db = mysqli_connect(self::$config['host'], self::$config['user'], self::$config['password'], self::$config['database'])
            or die('Trouble with connection database: ' . mysqli_connect_error());
    }

// to add some information to table
    public function insert($table, array $fields, array $values)
    {
        $fields = implode(", ", $fields);
        $values = "'" . implode("','", $values) . "'";

        $request = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $fields, $values);
        mysqli_query(self::$db, $request);
    }

// to get information from table
    public static function getData($table)
    {
        // todo: is not ready
        $request = sprintf('SELECT * FROM %s', $table);
        $result = mysqli_query(self::$db, $request);
        return mysqli_fetch_row($result);
    }
    /*
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