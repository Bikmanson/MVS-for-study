<?php

use framework\Exception\ConfigException;
use framework\Exception\Exception404;
use framework\Exception\NotExistException;

/**
 * This class:
 */
class Application
{
    private static $config;

    public static function autoload($className)
    {
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        if (!file_exists($fileName)) {

            $includeClassName = array_pop(explode('\\', $className));
            $path = str_replace($includeClassName, '', $className);

            $matches = [];
            preg_match('/([A-Z])/', $path, $matches);
            foreach ($matches as $match) {
                $path = str_replace($match, '-' . lcfirst($match), $path);
            }
            $fileName = $path . $includeClassName . '.php';

        }

        if (file_exists($fileName)) {
            require_once $fileName;
        } else {
            return;
        }
    }

    /**
     * @param $configuration
     * @throws ConfigException
     * @throws Exception404
     * recognizes controller and method names from address bar
     * creates objects for these
     * realizes method
     */
    function run($configuration)
    {
        /**
         * configuration
         */
        if (is_array($configuration)) {
            self::$config = $configuration;
        } else {
            throw new ConfigException('Incorrect configuration for this application. Must be array.');
        }

        /**
         * create array with components, ruled by path
         */
        $path = $_SERVER['REQUEST_URI']; // all path from address bar, written by client
        $components = preg_split('~/{1,}~', $path, 0, PREG_SPLIT_NO_EMPTY); // array creating

        //--------------assign objects to variables--------------------

        try {
            $controllerClassName = 'controllers\\' . ucfirst($components[0]) . 'Controller';

            // class name
            if (!$components[0]) {
                throw new NotExistException('You didn\'t specify needed class');
            } elseif (!class_exists($controllerClassName)) {
                throw new NotExistException('Received controller doesn\'t exist');
            } else {
                $class = $controllerClassName;
            }

            $controllerMethodName = 'action' . ucfirst($components[1]);

            // method name
            if (!$components[1]) {
                throw new NotExistException('You didn\'t specify needed method');
            } else if (!method_exists($class, $controllerMethodName)) {
                throw new NotExistException('Not existing method!');
            } else {
                $method = $controllerMethodName;
            }
        } catch (NotExistException $e) {
            echo $e->getMessage();
            return;
        }

        //_____________assign objects to variables_____________________
        try {
            // realize request
            $controller = new $class();

            /**
             * parameters...
             */
            $rm = new ReflectionMethod($class, $method);
            $parameterArray = $rm->getParameters(); // parameters array

            /**
             * necessary parameters
             * if they are not assigned in request - throws Exception
             */
            $necessaryParameterKeys = [];
            for ($i = 0; $i < count($parameterArray); $i++) {
                $rp = new ReflectionParameter([$class, $method], $i);
                if (!$rp->isOptional()) {
                    $necessaryParameterKeys[] = $rp->name;
                }
            }
            foreach ($necessaryParameterKeys as $key) {
                if (!$_GET[$key]) {
                    throw new Exception404('Not existing page');
                }
            }

            /**
             * assigns parameter values from request to action parameters
             */
            $parameters = [];
            if ($parameterArray) {
                foreach ($parameterArray as $parameter) {
                    if ($_GET[$parameter->name]) {
                        $parameters[] = $_GET[$parameter->name];
                    }
                }
                unset($parameter);
            }

            /**
             * request action
             */

            if ($parameterArray) {
                echo $rm->invokeArgs($controller, $parameters);
            } else {
                echo $controller->$method($parameters);
            }

        } catch (Exception404 $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return mixed
     */
    public static function getConfig()
    {
        return self::$config;
    }

    /**
     * @param $key
     * @param $val
     * @return mixed
     */
    public static function setConfig($key, $val)
    {
        return self::$config[$key] = $val;
    }
}