<?php


namespace framework\database;

use Application;

class DBStorage implements IStorage
{
    private static $config;
    private static $db;

    /**
     * @return bool
     * connecting with database
     */
    public static function init()
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

    /**
     * @param $table
     * @param array $fields
     * @param array $values
     * to add some information to table
     */
    public function insert($table, array $fields, array $values)
    {
        $fields = implode(", ", $fields);
        $values = "'" . implode("','", $values) . "'";

        $request = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $fields, $values);
        mysqli_query(self::$db, $request);
    }

    /**
     * @param $table
     * @return array|null
     * to get information from table
     */
    public static function find($table)
    {
        if (!self::$db) {
            self::init();
        }
        $request = sprintf('SELECT * FROM %s', $table);
        $tableData = mysqli_query(self::$db, $request);
        $result = [];
        while ($row = mysqli_fetch_array($tableData)) {
            $result[] = $row;
        }
        return $result;
    }

    public static function update($table, $id)
    {
        if (!self::$db) {
            self::init();
        }
        $request = sprintf('SELECT * FROM %s WHERE id = %d', $table, $id);
        $field = mysqli_query(self::$db, $request);
        $result = [];
        while($row = mysqli_fetch_array($field)){
            $result[] = $row;
        }
        return $result;
    }

    /*
        public function getElement(int $id)
        {
        }

        public function delete(int $id)
        {
        }
    */
}