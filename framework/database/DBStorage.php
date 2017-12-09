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

    public static function update($table, $id, $fieldNames, $nameValues)
    {
        if (!self::$db) {
            self::init();
        }
        /**
         * makes assigning of all field names
         */
        $assigning = '';
        for($i = 0; $i < count($fieldNames); $i++){
            if($assigning !== ''){
                $assigning .= ', ' . $fieldNames[$i] . ' = "' . $nameValues[$i] . '"';
            } else {
                $assigning = $fieldNames[$i] . ' = "' . $nameValues[$i] . '"';
            }
        }
        $request = sprintf('UPDATE %s SET %s WHERE id = %d', $table, $assigning, $id);
        mysqli_query(self::$db, $request);
    }

        public static function getModelById($table, $id)
        {
            if (!self::$db) {
                self::init();
            }
            $request = sprintf('SELECT * FROM %s WHERE id = %d', $table, $id);
            $queryResult = mysqli_query(self::$db, $request);
            $result = [];
            while($row = mysqli_fetch_array($queryResult)){
                $result[] = $row;
            }
            return $result;
        }

        public static function delete($table, $id)
        {
            if (!self::$db) {
                self::init();
            }
            $request = sprintf('DELETE FROM %s WHERE id = %d', $table, $id);
            mysqli_query(self::$db, $request);
        }
}