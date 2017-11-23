<?php

/**
 * Parent class Controller
 *
 * has method render
 */
class Controller
{

    protected $layout = 'main';

    /**
     * @param $viewFileName
     * @param array $data
     * @return string
     * make request to needed viewer
     * return this to request method
     */
    function render($viewFileName, array $data = []){
        $fileName = $viewFileName . '.php'; // view file name

        // recognize daughter class, requested this method - controller name
        $controller = preg_split("/controller/", strtolower(static::class), -1 , PREG_SPLIT_NO_EMPTY)[0];

        extract($data); // extracting variables with values from associating array - for future...

        ob_start(); // start save next expressions to buffer, not to screen
        require __DIR__ . '/../views/' . $controller . '/' . $fileName; // finish path to needed view file
        $viewContent = ob_get_clean(); // get buffer content (like string) and finish buffer with cleaning - return string

        if(!$this->layout){
            return $viewContent;
        }

        $layoutFileName = __DIR__ . '/../layout/' . $this->layout . '.php';

        $content = $viewContent;

        ob_start();
        require $layoutFileName;
        return ob_get_clean();

        //  TODO: existing checking for $fileName
    }

}