<?php

use framework\Exception\ConfigException;
use framework\Exception\NotExistException;

/**
 * This class:
 */
class Application
{

    private $path; // address bar
    private $components; // array with components
    private $class; // class to request its object
    private $method; // method to request from class
    private $controller; // controller named by class name
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
        require_once $fileName;

    }

    /**
     * @param $configuration
     * @throws ConfigException
     * @throws NotExistException
     * recognizes controller and method names from address bar
     * creates objects for these
     * realizes method
     */
    function run($configuration)
    {
        if (is_array($configuration)) {
            self::$config = $configuration;
        } else {
            throw new ConfigException('Incorrect configuration for this application. Must be array.');
        }

        //create array with components, ruled by path
        $this->path = $_SERVER['REQUEST_URI']; // all path from address bar, written by client
        $this->components = preg_split('~/{1,}~', $this->path, 0, PREG_SPLIT_NO_EMPTY); // array creating

        //--------------assign objects to variables--------------------

        $controllerClassName = 'controllers\\' . ucfirst($this->components[0]) . 'Controller';

        // class name
        if (!$this->components[0]) {
            throw new NotExistException('You didn\'t specify needed class');
        } else if (class_exists($controllerClassName)) {
            $this->class = $controllerClassName;
        }

        // method name
        if ($this->components[1] == null) {
            throw new NotExistException('You didn\'t specify needed method');
        } else if (method_exists($this->class, 'action' . ucfirst($this->components[1]))) {
            $this->method = 'action' . ucfirst($this->components[1]);
        } else {
            throw new NotExistException('Not existing method!');
        }

        //_____________assign objects to variables_____________________

        // realize request
        $this->controller = new $this->class();
        try{
            echo $this->controller->{$this->method}();
        } catch(ConfigException $e){
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