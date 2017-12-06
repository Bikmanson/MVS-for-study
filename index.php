<?php

use framework\Exception\ConfigException;
use framework\Exception\NotExistException;

require_once 'framework/Application.php';
spl_autoload_register('Application::autoload');
$config = require('config/main.php');
$application = new Application();

$application->run($config);


try {
} catch (ConfigException $e) {
    echo $e->getMessage();
} catch (NotExistException $e) {
    echo $e->getMessage();
}