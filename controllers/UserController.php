<?php

namespace controllers;

use Application;
use framework\Controller;
use framework\Exception\ConfigException;
use framework\Exception\WrongStorageException;
use http\QueryString;
use models\User;

/**
 * Class UserController
 * action functions
 * leading to needed viewers
 */
class UserController extends Controller
{

    /**
     * @return string
     * @throws ConfigException
     * leads to index viewer
     */
    public function actionIndex()
    {
        $users = User::find();
        $title = 'Users';
        return $this->render('index', [
            'users' => $users,
            'title' => $title
        ]);
    }

    /**
     * @return string
     * leads to create viewer
     */
    public function actionCreate()
    {
        $user = new User();
        $user->first_name = $_POST['firstName'];
        $user->last_name = $_POST['lastName'];
        $user->age = $_POST['age'];

        if ($user->validate()) {
            $user->save();
            return $this->render('create', [
                'massage' => 'User is saved successfully'
            ]);
        } else {
            return $this->render('create', [
                'massage' => $user->getErrorsSummary(),
                'user' => $user
            ]);
        }
    }

    public function actionUpdate($id)
    {

        $field = User::updata($id);
        return $this->render('update', [
            'field' => $field
        ]);
    }
}