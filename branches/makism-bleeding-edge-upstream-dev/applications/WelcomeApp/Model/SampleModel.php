<?php

// *Always*, your Model must:
// 1) extend "leaf_Model", and
// 2) have a name ending the string "_Controller".
//
// If those two requirements, are not met,
// your Controller will be ignored, and an error
// will be raised.
//
// Also, you *must*, call the parent`s contructor,
// in order to have your Model working properly.
class SampleModel_Model extends leaf_Model {
    
    const BIND_NAME = "SampleModel";
    

    public function init()
    {
    
    }
    
    public function destroy()
    {
    
    }
    
    public function getPageTitle()
    {
        return "&#8220;leaf framework ~ Open Source MVC Framework in PHP&#8221;";
    }

}

?>
