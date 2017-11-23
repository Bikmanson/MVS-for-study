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
     * return this to request method
     */
    function render($viewFileName, array $data = []){
        $fileName = 'action' . ucfirst($viewFileName) . '.php'; // view file name

        // recognize daughter class, requested this method - controller name
        $controller = preg_split("/controller/", strtolower(static::class), -1 , PREG_SPLIT_NO_EMPTY)[0];

        extract($data); // extracting variables with values from associating array - for future...

        ob_start(); // start save next expressions to buffer, not to screen
        require __DIR__ . '/../views/' . $controller . '/' . $fileName; // finish path to needed view file
        return ob_get_clean(); // get buffer content (like string) and finish buffer with cleaning - return string

        //  TODO: existing checking for $fileName
    }

}