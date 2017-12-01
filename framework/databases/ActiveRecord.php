<?php

abstract class ActiveRecord
{
    protected $table;
    protected $errors = [];
    protected $empty = 0;

    abstract protected function rules();

    abstract protected function attributes();

    public function validate()
    {
        $bool = true;
        foreach ($this->rules() as $rule) {
            if ($bool) $bool = $this->$rule(); else $this->$rule();
        }
        if($this->empty === count($this->rules())){
            $this->errors[] = 'Every field is empty. Input please';
            $bool = false;
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
