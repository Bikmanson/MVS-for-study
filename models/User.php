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

    function __construct($firstName, $lastName, $age)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;

        $fields = ['first_name', 'last_name', 'age'];
        $values = [$this->firstName, $this->lastName, $this->age];

        $this->add('users', $fields, $values);
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