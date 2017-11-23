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
        $fileName = $viewFileName . '.php'; // view file name
        $controller = strtolower(static::class); // recognize daughter class, requested this method - controller name

        extract($data); // extracting variables with values from associating array - for future...

        ob_start(); // start save next expressions to buffer, not to screen
        require __DIR__ . '/../views/' . $controller . '/' . $fileName; // finish path to needed view file
        return ob_get_clean(); // get buffer content (like string) and finish buffer with cleaning - return string

        //TODO: existing checking for $fileName
    }

}