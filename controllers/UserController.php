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

        // creates new User object
        if($_POST['firstName'] || $_POST['lastName'] || $_POST['age']){
            $firstName = $_GET['firstName'];
            $lastName = $_GET['lastName'];
            $age= $_GET['age'];
            new User ($firstName, $lastName, $age); //TODO: add this object to db
        }
        return $this->render('create');
    }

}