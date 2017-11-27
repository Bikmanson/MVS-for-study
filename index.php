<?php

//---------------------requirements---------------------

// instruments
require_once 'framework/databases/IStorage.php'; // interface
// require_once 'framework/databases/DBStorage.php'; // implements interface
// require_once 'framework/databases/JsonStorage.php'; // implements interface

// parents
require_once 'framework/databases/ActiveRecord.php'; // ancestor
require_once 'framework/Model.php'; // heir and parent
require_once 'framework/Controller.php'; // parent

// heirs
require_once 'controllers/UserController.php'; // controller
require_once 'models/User.php'; // model

// main application
require_once 'framework/Application.php';

//______________________requirements______________________

$config = require ('config/main.php');

$application = new Application();
$application->run($config);