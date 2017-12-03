<?php

abstract class ActiveRecord
{
    protected $errors = [];

    abstract protected function rules();

    abstract protected function attributes();

    public function validate()
    {
        $bool = true;
        foreach ($this->rules() as $rule) {
            if(is_string($rule)){
                if ($bool) {
                    $bool = $this->$rule();
                } else {
                    $this->$rule();
                }
            }elseif(is_callable($rule)){
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
     * records data from $attributes to storage class
     */
    public function save()
    {
        // new storage class object
        $storageClass = Application::getConfig()['storage']['class'];
        $storageClass = new $storageClass();
        $storageClass->connect();

        // receive fields for insert into
        $fields = array_keys($this->attributes());

        $values = [];
        foreach ($this->attributes() as $field => $value) {
            $values[] = $value;
        }

        // insert new data to database
        $storageClass->insert(static::getTableName(), $fields, $values);
    }
}
