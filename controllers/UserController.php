<?php

namespace controllers;

use framework\Controller;
use framework\Exception\ConfigException;
use framework\Exception\Exception404;
use framework\Exception\NotExistException;
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
        } elseif (empty($_POST)) {
            return $this->render('create', [
                'massage' => '',
                'user' => $user
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
        $field = User::update($id);
        $massage = '';
        if ($_POST) {
            $user = new User();
            $user->first_name = $_POST['firstName'];
            $user->last_name = $_POST['lastName'];
            $user->age = $_POST['age'];

            if ($user->validate()) {
                $fieldNames = [
                    'first_name',
                    'last_name',
                    'age'
                ];
                $nameValues = [
                    $_POST['firstName'],
                    $_POST['lastName'],
                    $_POST['age']
                ];
                User::update($id, $fieldNames, $nameValues);
                $field = User::update($id);
                $massage = 'User data changed successfully';
            } else {
                $massage = $user->getErrorsSummary();
                $field = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'age' => $user->age
                ];
            }
        }
        return $this->render('update', [
            'field' => $field,
            'massage' => $massage
        ]);
    }

    public function actionDelete()
    {
        if ($_GET) {
            try{
                $id = $_GET['id'];
                $user = User::update($id);
                if(!$user){
                    throw new Exception404('user not exist');
                }
                User::delete($id);
                return $this->render('delete', [
                    'user' => $user
                ]);
            } catch (Exception404 $e) {
                echo $e->getMessage();
            }
        }
    }
}