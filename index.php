<?php

require_once 'framework/databases/IStorage.php';
require_once 'framework/ActiveRecord.php';
require_once 'framework/Controller.php';
require_once 'framework/Model.php';
require_once 'framework/DB.php';
require_once 'assets/sql/connection.php';
require_once 'controllers/UserController.php';
require_once 'models/UserModel.php';
require_once 'framework/Application.php';

$application = new Application();
$application->run();
