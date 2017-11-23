<?php

/**
 * This class:
 *
 * recognize controller and method names from address bar
 * create objects for these
 * realize
*/
class Application
{

    private $path; // address bar
    private $components; // array with components
    private $class; // class to request its object
    private $method; // method to request from class
    private $controller; // controller named by class name

    function run()
    {

        //create array with components, ruled by path
        $this->path = $_SERVER['REQUEST_URI']; // all path from address bar, written by client
        $this->components = preg_split('~/{1,}~', $this->path, 0, PREG_SPLIT_NO_EMPTY); // array creating

        //------------for change-------------



        //_____________for change____________

        //--------------assign objects to variables--------------------

        // class name
        if($this->components[0] == null){
            echo 'You didn\'t specify needed class';
            return;
        } else if (class_exists(ucfirst($this->components[0]) . 'Controller')) {
            $this->class = ucfirst($this->components[0]) . 'Controller';
        } else {
            echo "Not existing class!";
            return;
        }

        // method name
        if($this->components[1] == null){
            echo 'You didn\'t specify needed method';
            return;
        } else if (method_exists($this->class, $this->components[1])) {
            $this->method = $this->components[1];
        } else {
            echo "Not existing method!";
            return;
        }

        //_____________assign objects to variables_____________________

        // realize request
        $this->controller = new $this->class();
        echo $this->controller->{$this->method}(); //TODO: What is it?

    }

}