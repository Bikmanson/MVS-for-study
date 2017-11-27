<?php
/**
 * Created by PhpStorm.
 * User: Oleks
 * Date: 28.11.2017
 * Time: 1:08
 */

class Sql
{

    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbName = 'php';

    protected static function connect()
    {

        return $db = mysqli_connect(self::$dbHost, self::$dbUsername, '', self::$dbName)
            or die('Trouble with connection database: ' . mysqli_connect_error());

    }

}