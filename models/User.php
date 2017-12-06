<?php

namespace models;

use framework\Model;


/**
 * Class User
 * like data base with information about users
 * adds new users
 */
class User extends Model
{

    private static $tableName = 'users';
    public $last_name;
    public $first_name;
    public $age;

    public function validate()
    {
        $empty = 0;
        $bool = true;
        $fields = self::attributes();
        foreach ($fields as $field) {
            if(!$this->$field){
                $empty++;
            }
        }
        if($empty === count($fields)){
            $bool = false;
            $this->errors[] = 'Every field is empty. Form will not be committed';
        }
        if($bool === true){
            $bool = parent::validate();
        }
        return $bool;
    }

    //--------------------implementations-------------------

    protected static function attributes()
    {
        return [
            'first_name',
            'last_name',
            'age'
        ];
    }

    /**
     * @return array
     */
    protected static function rules()
    {
        return [
            'firstName' => 'firstNameValidator',
            'lastName' => 'lastNameValidator',
            'age' => 'ageValidator'
        ];
    }

    //____________________implementations___________________

    //-------------------------validators-------------------------

    protected function firstNameValidator()
    {
        $bool = true;
        if (!(preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄсур\-]+$/', $this->first_name)) && $this->first_name !== '') {
            $this->errors[] = 'Used forbidden characters';
            $bool = false;
        }
        if (!(strlen($this->first_name) <= 20)) {
            $this->errors[] = 'Very long name! Must be in range of 20';
            $bool = false;
        }
        if ($this->first_name === '') {
            $bool = true;
        }

        return $bool;
    }

    protected function lastNameValidator()
    {
        $bool = true;

        if (!(preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄсур\-]+$/', $this->last_name)) && $this->last_name !== '') {
            $this->errors[] = 'Used forbidden characters';
            $bool = false;
        }
        if (!(strlen($this->last_name) <= 20)) {
            $this->errors[] = 'Very long name! Must be in range of 20';
            $bool = false;
        }
        if ($this->last_name === '') {
            $bool = true;
        }

        return $bool;
    }

    protected function ageValidator()
    {
        $bool = true;

        if (!preg_match('/\d/', $this->age) && $this->age !== '') { // is digits checking
            $this->errors[] = 'Field age access digits only';
            $bool = false;
        } elseif (!($this->age <= 120) && ($this->age > 0)) { // is in range of checking
            $this->errors[] = 'Very old human - it\'s impossible';
            $bool = false;
        }
        if ($this->age === '') {
            $this->age = '';
            $bool = true;
        }
        return $bool;
    }

    //_________________________validators_________________________

    //-------------------------getters and setters------------------------

    /**
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }

    //___________________________________getters and setters_____________________________

}