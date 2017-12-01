<?php

abstract class ActiveRecord
{
    protected $table;
    protected $errors = [];

    abstract protected function rules();

    abstract protected function attributes();

    public function validate() // TODO: doesn't access empty fields. Even one of
    {
        $bool = true;
        foreach ($this->rules() as $rule) {
            if ($bool) $bool = $this->$rule(); else $this->$rule();
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
        $storageClass = Application::getConfig('storageClass');
        $storageClass = new $storageClass();

        // receive fields for insert into
        $fields = array_keys($this->attributes());

        $values = [];
        foreach ($this->attributes() as $field => $value) {
            $values[] = $value;
        }

        // insert new data to database
        $storageClass->insert($this->table, $fields, $values);
    }
}
