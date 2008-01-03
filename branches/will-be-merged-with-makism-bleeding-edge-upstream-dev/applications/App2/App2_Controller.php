<?php

class App2_Controller extends leaf_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        echo "Testing multiple dispatch calls ~ working as expected (that, is a bit faulty :P).<br/><br/>";
        
        $this->Dispatcher->invoke("SampleApplication", "index");
        $this->Dispatcher->invoke("SampleApplication", "hooks");
    }

}
