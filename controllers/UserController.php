<?php

/**
 * Class UserController
 * action functions
 */
class UserController extends Controller
{

    public function index(){
        $users = UserModel::getAll(); // all information about users from model

        // return request to viewer
        return $this->render('index', [
            'title' => 'Users',
            'users' => $users // value is array
        ]); // - require __DIR__ . '/../views/user/index.php'; <-- to delete
    }

    //TODO: What is it?
    public function create()
    {
        return $this->render('create');
    }

}