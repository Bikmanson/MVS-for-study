<?php

require_once 'framework/Controller.php';
require_once 'framework/Model.php';
require_once 'controllers/UserController.php';
require_once 'models/UserModel.php';
require_once 'framework/Application.php';

$application = new Application();
$application->run();