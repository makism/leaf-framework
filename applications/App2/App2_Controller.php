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


        $testController =
            $this->Dispatcher->pretend("AnotherApp", "someAction");

        if ($testController)
            $this->Dispatcher->invoke();
    }

}

