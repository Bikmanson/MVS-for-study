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
        $users = UserModel::getAll(); // all information about users from model

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
        return $this->render('create');
    }

}