<?php

/**
 * Class UserController
 * action functions
 * leading to needed viewers
 */
class UserController extends Controller
{

    /**
     * @return string
     * leads to index viewer
     */
    public function actionIndex(){
        $users = User::getAll(); // all information about users from model

        // return request to viewer
        return $this->render('index', [
            'title' => 'Users',
            'users' => $users // value is array
        ]); // - require __DIR__ . '/../views/user/index.php'; <-- to delete
    }

    /**
     * @return string
     * leads to create viewer
     */
    public function actionCreate()
    {
//TODO: adds information to database again after window reloading - fix!!!
        // creates new User object
        if($_POST['firstName'] || $_POST['lastName'] || $_POST['age']){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $age= $_POST['age'];
            new User ($firstName, $lastName, $age);
        }
        return $this->render('create');
    }

}