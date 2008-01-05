<?php

// *Always*, your Controller must:
// 1) extend "leaf_Controller", and
// 2) have a name ending with the string "_Controller".
//
// If those two requirements, are not met,
// your Controller will be ignored, and an error
// will be raised.
//
// Also, you *must*, call the parent`s contructor,
// in order to have your Controller working properly.
class SampleApplication_Controller extends leaf_Controller {

    public function init()
    {
        
    }
    
    public function destroy()
    {
    
    }

	public function index($Request, $Response)
	{
        
	}

}

?>
