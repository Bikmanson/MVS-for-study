<?php

namespace framework\database;

use Application;
use framework\Exception\ConfigException;
use framework\Exception\WrongStorageException;

abstract class ActiveRecord
{
    protected $errors = [];
    private $storage;

    /**
     * ActiveRecord constructor.
     * @throws ConfigException
     */
    function __construct()
    {
        $storageClass = Application::getConfig()['storage']['class'];
        if (!$storageClass) {
            throw new ConfigException('The configuration doesn\'t exist storage class name');
        } else {
            $this->storage = new $storageClass();
            if(!$this->storage instanceof IStorage){
                throw new WrongStorageException('The storage from configuration is not instance of needed interface!');
            } else {
                call_user_func([$storageClass, 'init']);
            }
        }
    }

//-------------------------------self methods-----------------------------
    abstract protected static function rules();

    abstract protected static function attributes();

    public function validate()
    {
        $bool = true;
        foreach (static::rules() as $rule) {
            if (is_string($rule)) {
                if ($bool) {
                    $bool = $this->$rule();
                } else {
                    $this->$rule();
                }
            } elseif (is_callable($rule)) {
                if ($bool) {
                    $bool = call_user_func($rule);
                } else {
                    call_user_func($rule);
                }
            }

        }
        return $bool;
    }

    public function getErrorsSummary()
    {
        $out = '';
        foreach ($this->errors as $error) {
            $out .= "<p>{$error}</p>";
        }
        return $out;
    }

    /**
     * @return mixed
     */
    public function getStorageClass()
    {
        return $this->storage;
    }

//____________________________________self methods__________________________________

//-----------------------------methods that use interface---------------------------

    /**
     * records data from $attributes to storage class
     */
    public function save()
    {
        // receive fields for insert into
        $fields = static::attributes();

        $values = [];
        foreach (static::attributes() as $attribute) {
            $values[] = $this->$attribute;
        }

        // insert new data to database
        $this->storage->insert(static::getTableName(), $fields, $values);
    }

    /**
     * @return array
     */
    public static function find(){
        $storage = Application::getConfig()['storage']['class'];
        $table = static::getTableName();
        $queryResult = $storage::find($table);
        $models = [];
        foreach ($queryResult as $row) {
            $modelClassName = static::class;
            $model = new $modelClassName;
            foreach (static::attributes() as $attribute) {
                $model->$attribute = $row[$attribute];
            }
            $models[] = $model;
        }
        return $models;
    }
//_______________________________methods that use interface___________________________
}