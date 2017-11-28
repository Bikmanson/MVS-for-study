<?php

class ActiveRecord
{

        public function add($table, array $fields, array $values){

            $storageClass = Application::getConfig('storageClass');
            $storageClass = new $storageClass();
            $fieldsString = implode(", ", $fields);
            $valuesString = "'" . implode("','", $values) . "'";

            $storageClass->add($table, $fieldsString, $valuesString);

        }

    /*
        static function getAll() // get all information about users
        {

            $storageClass = Application::getConfig('storageClass');

        }
    */
}
