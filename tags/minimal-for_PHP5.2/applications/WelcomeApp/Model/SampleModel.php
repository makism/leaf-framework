<?php

// *Always*, your Model must:
// 1) extend "leaf_Model", and
// 2) have a name ending the string "_Model".
// 3) you have to provide an implmentation for
//    the method "init"
class SampleModel_Model extends leaf_Model {
    
    const BIND_NAME = "SampleModel";
    

    public function init()
    {
    
    }
    
    public function getPageTitle()
    {
        return "&#8220;leaf framework ~ Open Source MVC Framework in PHP&#8221;";
    }

}

