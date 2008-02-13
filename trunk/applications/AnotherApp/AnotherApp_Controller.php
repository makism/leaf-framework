<?php

/*
 * This controller is disabled.
 * To enable it, simply remove the line:
 * `const IS_ENABLED = FALSE;`
 */
class AnotherApp_Controller extends leaf_Controller {

    const ALLOW_CALL = TRUE;

    const IS_ENABLED = FALSE;


    public function init()
    {
        echo __METHOD__ . "<br/>";
    }
    
    public function destroy()
    {
        echo __METHOD__ . "<br/>";
    }
    
    public function index()
    {
        echo __METHOD__ . "<br/>";
    }

    public function someAction($Request, $Response)
    {
        echo __METHOD__ . "<br/>";
    }

}

