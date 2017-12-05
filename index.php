<?php
require_once 'framework/Application.php';
spl_autoload_register('Application::autoload');
$config = require ('config/main.php');
$application = new Application();
$application->run($config);