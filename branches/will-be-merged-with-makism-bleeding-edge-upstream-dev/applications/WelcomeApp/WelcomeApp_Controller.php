<?php

// Your Controller must:
// 1) extend "leaf_Controller",
// 2) have a name suffixed with "_Controller".
// 3) *never* implement a constructor,
//    UNLESS it has the following signature:
//    public function __construct($controllerName)
//
// If the two top requirements, are not met,
// your Controller will be ignored, and an error
// will be raised.
//
// If you implement your own constructor, the first
// statement inside your constructor should be:
//  parent::__construct($controllerName);
// in case you supply  a different signature, the
// whole application will not work as expected,
// or not work at all...
final class WelcomeApp_Controller extends leaf_Controller {

    public function init()
    {
        
    }
    
    public function destroy()
    {
        
    }

	public function index($Request, $Response)
	{
        $data['title']= "&#8220;leaf framework ~ Open Source MVC Framework in PHP&#8221;";
        
        $this->View->render("main", $data);
	}

}
