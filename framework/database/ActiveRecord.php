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
        $table = static::getTableName();

        $values = [];
        foreach ($fields as $attribute) {
            $values[] = $this->$attribute;
        }

        // insert new data to database
        $this->storage->insert($table, $fields, $values);
    }

    /**
     * @return array
     */
    public static function find(){
        $storage = Application::getConfig()['storage']['class'];
        $table = static::getTableName();
        $queryResult = $storage::find($table);
        $models = [];
        $modelClassName = static::class;
        foreach ($queryResult as $row) {
            $model = new $modelClassName;
            foreach (static::attributes() as $attribute) {
                $model->$attribute = $row[$attribute];
            }
            $models[] = $model;
        }
        return $models;
    }

    public static function update($id, $fieldNames = null, $nameValues = null){
        $storage = Application::getConfig()['storage']['class'];
        $table = static::getTableName();

        if($fieldNames === null && $nameValues === null){
            $model = $storage::getModelById($table, $id);
            $attributes = static::attributes();
            $result = [];
            foreach ($attributes as $attribute) {
                foreach ($model as $data) {
                    $result[$attribute] = $data[$attribute];
                }
            }
            return $result;
        }
        $storage::update($table, $id, $fieldNames, $nameValues);
    }

    public static function delete($id){
        $table = static::getTableName();
        $storage = Application::getConfig()['storage']['class'];
        $storage::delete($table, $id);
    }

//_______________________________methods that use interface___________________________
}