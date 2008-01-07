<?php

class AnotherApp_Controller extends leaf_Controller {

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
