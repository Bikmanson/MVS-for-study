<?php

class ActiveRecord
{

    protected $attributes = [];

    /**
     * records data from $attributes to storage class
     */
    public function save()
    {
        // new storage class object
        $storageClass = Application::getConfig('storageClass');
        $storageClass = new $storageClass();

        // table name
        $table = $this->attributes['table'];
        array_shift($this->attributes);

        // fields / columns
        $fields = array_keys($this->attributes);

        // values to fields
        $values = [];
        foreach ($this->attributes as $attribute) {
            $values[] = $attribute;
        }
        unset($attribute);

        // insert new data to database
        $storageClass->insert($table, $fields, $values);
    }

}
