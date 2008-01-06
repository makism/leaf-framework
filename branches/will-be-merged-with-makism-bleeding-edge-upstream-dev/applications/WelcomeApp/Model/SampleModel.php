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
    
    const BIND_NAME = "sample";
    

    /*
     * Init our model.
     */
	public function __construct()
	{
        // Call the parent`s contructor.
		parent::__construct("SampleApplication");
	}

    /*
     * Return the page`s title.
     */
    public function getPageTitle()
    {
        return "&#8220;leaf framework, Sample Application&#8221";
    }

}

?>
