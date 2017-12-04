<?php

/**
 * Class User
 * like data base with information about users
 * adds new users
 */

class User extends Model
{

    private static $tableName = 'users';
    private $lastName;
    private $firstName;
    private $age;
    protected $empty = 0;

    //temporary realizing of this method - it will works differently
    static function getAll() // get all information about users // TODO: shift to parent ActiveRecord class
    {
        //TODO: delete this
        $u1 = new User('Vasya', 'Storojenko', 21);
        $u2 = new User('Vitya', 'Bikman', 21);
        $u3 = new User('Vlad', 'Taran', 22);

        return [$u1, $u2, $u3];

    }

    //--------------------implementations-------------------

    protected function attributes()
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'age' => $this->age
        ];
    }

    protected function rules()
    {
        return [
            'firstName' => 'firstNameValidator',
            'lastName' => 'lastNameValidator',
            'age' => 'ageValidator',
            'emptyError' => function () {
                if ($this->empty === (count($this->rules()) - 1)) {
                    $this->errors[] = 'Every field is empty. Input please';
                    return false;
                } else {
                    return true;
                }
            }
        ];
    }

    //____________________implementations___________________

    //-------------------------validators-------------------------

    protected function firstNameValidator()
    {
        $bool = true;
        if (!(preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄсур\-]+$/', $this->firstName)) && $this->firstName !== '') {
            $this->errors[] = 'Used forbidden characters';
            $bool = false;
        }
        if (!(strlen($this->firstName) <= 20)) {
            $this->errors[] = 'Very long name! Must be in range of 20';
            $bool = false;
        }
        if ($this->firstName === '') {
            $this->empty++;
            $bool = true;
        }

        return $bool;
    }

    protected function lastNameValidator()
    {
        $bool = true;

        if (!(preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄсур\-]+$/', $this->lastName)) && $this->lastName !== '') {
            $this->errors[] = 'Used forbidden characters';
            $bool = false;
        }
        if (!(strlen($this->lastName) <= 20)) {
            $this->errors[] = 'Very long name! Must be in range of 20';
            $bool = false;
        }
        if ($this->lastName === '') {
            $this->empty++;
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
            $this->empty++;
            $bool = true;
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

    /**
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }

    //___________________________________getters and setters_____________________________

}