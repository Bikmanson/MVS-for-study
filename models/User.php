<?php

/**
 * Class User
 * like data base with information about users
 * adds new users
 */

class User extends Model
{

    private $firstName;
    private $lastName;
    private $age;
    public $attributes = ['firstName' => '', 'lastName' => '', 'age' => ''];


    function __construct()
    {
        $this->table = 'users';
    }

    //temporary realizing of this method - it will works differently
    static function getAll() // get all information about users // TODO: shift to parent ActiveRecord class
    {
        //TODO: delete this
        $u1 = new User('Vasya', 'Storojenko', 21);
        $u2 = new User('Vitya', 'Bikman', 21);
        $u3 = new User('Vlad', 'Taran', 22);

        return [$u1, $u2, $u3];

    }

    function rules()
    {

    }

    //-------------------------validators-------------------------

    protected function firstNameValidator() // TODO: << because of access modifier. And below too
    {
        $bool = true;

        if((!preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄ\-]$/', $this->firstName)) && $this->firstName !== ''){ //TODO: << !== | && <<?
            $this->errors .= 'used forbidden characters';
            $bool = false;
        }elseif(!strlen($this->firstName) <= 20){
            $this->errors .= 'very long name';
            $bool = false;
        }

        return $bool;
    }

    protected function lastNameValidator()
    {
        $bool = true;

        if(!preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄ\-]$/', $this->lastName) && $this->lastName !== ''){
            $this->errors .= 'used forbidden characters';
            $bool = false;
        }elseif(!strlen($this->lastName) <= 20){
            $this->errors .= 'very long name';
            $bool = false;
        }

        return $bool;
    }

    protected function ageValidator()
    {
        $bool = true;

        if((!$this->age <= 20) && ($this->age !== '')){
            $this->errors .= 'very long name';
            $bool = false;
        }

        return $bool;
    }

    //_________________________validators_________________________

    //-------------------------getters and setters------------------------

    // firstName
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    // lastName
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    // age
    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    //___________________________________getters and setters_____________________________

}