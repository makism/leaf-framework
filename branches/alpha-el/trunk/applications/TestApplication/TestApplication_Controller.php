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
class TestApplication_Controller extends leaf_Controller {


	public function __construct()
	{
        // Call the parent`s contructor.
		parent::__construct();

        // Load SampleModel and bind it under the name 'sample'.
        //$this->loader->model('SampleModel', array('Bind'=>'sample'));
        
        // Change on the fly, the configuration, so 
        // no debug statistics are created.
        $this->config['enable_debug_stats'] = "No";
	}

	public function index()
	{
		// Create the data
		$data['title'] = "&#8220;leaf framework, Sample Application&#8221";
		
        // Print a welcome message.
        $this->view->render("main", $data);

        // Retrieve from the query string the variable 'name'.
        // Then, print the contents (if any).
        //$testQString = $this->request->getQueryString('name');

        //if (!empty($testQString))
        //    echo $testQString;
	}

}

?>
