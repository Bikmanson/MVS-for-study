<?php

use framework\Exception\ConfigException;
use framework\Exception\NotExistException;

require_once 'framework/Application.php';
spl_autoload_register('Application::autoload');
$config = require('config/main.php');
$application = new Application();

try {
    $application->run($config);
} catch (ConfigException $e) {
    echo $e->getMessage();
} catch (NotExistException $e) {
    echo $e->getMessage();
}