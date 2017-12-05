<?php
namespace controllers;

use Application;
use cN\TestNamespace;
use framework\Controller;
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
     * leads to index viewer
     */
    public function actionIndex()
    {
        //TODO: this expression creates three new users - delete it!
        $storageClass = Application::getConfig()['storage']['class'];
        $users = call_user_func_array(Array($storageClass, 'getDate'), Array(User::getTableName()));
        //$users = User::getDate(); // all information about users from model

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
        $a = new TestNamespace();
        $a->pr();
        $user = new User();
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setAge($_POST['age']);

        if ($user->validate()) {
            $user->save();
            return $this->render('create',[
                'massage' => 'User is saved successfully'
            ]);
        } else {
            return $this->render('create', [
                'massage' => $user->getErrorsSummary(),
                'user' => $user
            ]);
        }
    }
}