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
    public function actionIndex()
    {
        //TODO: this expression creates three new users - delete it!
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

        $user = new User();
        $user->setFirstName($_POST['firstName']);
        $user->setLastName($_POST['lastName']);
        $user->setAge($_POST['age']);

        if ($user->validate()) {
            $user->save();
            return $this->render('create', [
                'massage' => 'User is saved successfully'
            ]);
        } else {

            echo $user->getErrorsSummary();

            return $this->render('create', [
                'massage' => $user->getErrorsSummary(),
                'user' => $user
            ]);
        }
    }
}