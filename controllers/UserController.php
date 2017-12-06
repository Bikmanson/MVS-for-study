<?php
namespace controllers;

use Application;
use framework\Controller;
use framework\Exception\ConfigException;
use framework\Exception\WrongStorageException;
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
        //TODO: this expression creates three new users - delete it!
        try{
            $storageClass = Application::getConfig()['storage']['class'];
            $user = new User(); // for connecting with database (in ActiveRecord constructor)
            if(!$storageClass){
                throw new ConfigException('The configuration doesn\'t exist storage class name');
            } else {
                $storage = new $storageClass;
                $table = User::getTableName();
                $usersData = $storage->getData($table);
                //$users = call_user_func_array(Array($storageClass, 'getData'), Array(User::getTableName()));
                //$users = User::getDate(); // all information about users from model

                // return request to viewer
                return $this->render('index', [
                    'title' => 'Users',
                    'users' => $users // value is array
                ]); // - require __DIR__ . '/../views/user/index.php'; <-- to delete
            }
        } catch (WrongStorageException $e){
            $e->getMessage();
        }
    }

    /**
     * @return string
     * leads to create viewer
     */
    public function actionCreate()
    {
//TODO: adds information to database again after window reloading - fix!!!
        try{
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
        } catch(ConfigException $e){
            echo $e->getMessage();
        } catch(WrongStorageException $e){
            echo $e->getMessage();
        }
    }
}