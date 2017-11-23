<?php

/**
 * Class UserModel
 * like data base with information about users
 */
class UserModel extends Model
{

    private $firstName;
    private $lastName;
    private $age;

    function __construct($firstName, $lastName, $age)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
    }

    //temporary realizing of this method - it will works differently
    static function getAll() // get all information about users
    {
       $u1 = new UserModel('Vasya', 'Storojenko', 21);
       $u2 = new UserModel('Vitya', 'Bikman', 21);
       $u3 = new UserModel('Vlad', 'Taran', 22);

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