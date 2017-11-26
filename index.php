<?php

require_once 'framework/databases/IStorage.php';
require_once 'framework/databases/ActiveRecord.php';
require_once 'framework/Controller.php';
require_once 'framework/Model.php';
require_once 'framework/databases/DB.php';
require_once 'controllers/UserController.php';
require_once 'models/User.php';
require_once 'framework/Application.php';

$config = require ('config/main.php');

$application = new Application();
$application->run($config);