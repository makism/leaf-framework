<?php

// *Always*, your Controller must:
// 1) extend "leaf_Controller", and
// 2) have a name ending the string "_Controller".
//
// If those two requirements, are not met,
// your Controller will be ignored, and an error
// will be raised.
//
// Also, you *must*, call the parent`s contructor,
// in order to have your Controller working properly.
class SampleApplication_Controller extends leaf_Controller {


	public function __construct()
	{
        // Call the parent`s contructor.
		parent::__construct();
		
		// Include some required plugins.
		$this->load->plugin("url");
        
        // Change on the fly, the configuration, so 
        // debug statistics are created only if requested.
        if ($this->request->queryStringKeyExists("debug"))
            $this->config['enable_debug_stats'] = "Yes";
	}

	public function index()
	{
		// Create the data
		$data['title'] = "&#8220;leaf framework, Sample Application&#8221";
		
        // Print a welcome message.
        $this->view->render("main", $data);
	}

}

?>
