<?php

abstract class ActiveRecord
{

    protected $table;
    protected $errors = [];

    abstract protected function rules();

    public function save()
    {
        // new storage class object
        $storageClass = Application::getConfig('storageClass');
        $storageClass = new $storageClass();

        $class = static::class;
        $fields = [];
        extract($class->$attributes);
        // TODO: why? If will not fix this - just create $attributes here and assign in heir constructor
        foreach ($class->$attributes as $attribute) {
            $fields[] = $attribute;
        }

        // insert new data to database
        $storageClass->insert($this->table, $fields, $values);
    }

}
