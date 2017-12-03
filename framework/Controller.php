<?php

/**
 * Parent class Controller
 *
 * has method render
 */
class Controller
{

        /**
     * @param $viewFileName
     * @param array $data
     * @return string
     * make request to needed viewer
     * return this to request method of inherited class
     */
    function render($viewFileName, array $data = []){

        $layout = Application::getConfig()['layout'];

        $fileName = $viewFileName . '.php'; // view file name

        // recognize daughter class, requested this method - controller name
        $controller = preg_split("/controller/", strtolower(static::class), -1 , PREG_SPLIT_NO_EMPTY)[0];

        extract($data); // extracting variables with values from associating array - for future...

        //------------------buffers without layout-----------------

        ob_start(); // start save next expressions to buffer, not to screen
        require __DIR__ . '/../views/' . $controller . '/' . $fileName; // finish path to needed view file
        $content = ob_get_clean(); // get buffer content (like string) and finish buffer with cleaning - return string

        if(!$layout){
            return $content;
        }

        //__________________buffers without layout___________________

        //------------------buffer with layout-----------------------

        $layoutFileName = __DIR__ . '/../layout/' . $layout . '.php';

        ob_start();

        require $layoutFileName;
        return ob_get_clean();

        //___________________buffer with layout_______________________
    }

}