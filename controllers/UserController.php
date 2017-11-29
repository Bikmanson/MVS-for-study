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

        // creates new User object
        if (isset($_POST)) {

            // check $_POST array for regex
            foreach ($_POST as $field => &$value) {
                if (!preg_match('/^\w+$/ui', $value)) {
                    $value = '';
                }
            }
            unset($value);

            extract($_POST); // assign variables with data


            // create new user in database
            if (!($firstName == '' && $lastName == '' && $age == 0)) {
                $user = new User ($firstName, $lastName, $age);
                $user->save();
            }

        } // if end
        return $this->render('create');
    }

}