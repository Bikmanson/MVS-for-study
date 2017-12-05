<?php

namespace framework\database;

use Application;

abstract class ActiveRecord
{
    protected $errors = [];
    private $storage;

    function __construct()
    {
        $storageClass = Application::getConfig()['storage']['class'];
        $this->storage = new $storageClass();
        if($this->storage instanceof IStorage){
            $this->storage->init();
        } else {
            echo 'Storage class doesn\'t implement IStorage interface';
            die();
        }

    }

//-------------------------------self methods-----------------------------
    abstract protected function rules();

    abstract protected function attributes();

    public function validate()
    {
        $bool = true;
        foreach ($this->rules() as $rule) {
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
        return $this->storageClass;
    }

//____________________________________self methods__________________________________

//-----------------------------methods that use interface---------------------------

    /**
     * records data from $attributes to storage class
     */
    public function save()
    {
        // receive fields for insert into
        $fields = array_keys($this->attributes());

        $values = [];
        foreach ($this->attributes() as $field => $value) {
            $values[] = $value;
        }

        // insert new data to database
        $this->storageClass->insert(static::getTableName(), $fields, $values);
    }
/*
    public static function getData(){
        echo 'hello';
        return call_user_func(Array($this->storageClass, 'getDate', static::getTableName));
    }
*/
//_______________________________methods that use interface___________________________
}
