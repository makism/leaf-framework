<?php

class App2_Controller extends leaf_Controller {

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
        $this->Dispatcher->invoke("AnotherApp", "someAction");
    }

}
