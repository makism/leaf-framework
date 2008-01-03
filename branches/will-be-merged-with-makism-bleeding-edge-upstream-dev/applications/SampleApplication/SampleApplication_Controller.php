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

	public function __construct()
	{
        parent::__construct();
        
        // Load the Sample Model.
        $this->Load->model("SampleModel", array("application"=>"SampleApplication"));
        
		// Include some required plugins.
		$this->Load->plugin("url");
		
		// Disable Hooks
		$this->Config['allow_hooks'] = FALSE;
	}

	public function index($r, $s)
	{
		// Populate the data array.
		$data['title'] = $this->sample->getPageTitle();
		$data['desc'] = "This is a test View, displayed by the Sample Application`s Controller.";
		
        // Print a welcome message.
        $this->View->render("main", $data, VIEW_MERGE);
	}
	
	public function stats()
	{
		$this->Config['enable_debug_stats'] = TRUE;
	}
	
	public function hooks()
	{
		appendQueryString("runConditional");
		echo make_link("", "Run conditional hook (based on query string)", APPEND_QUERYSTRING);
		echo "<br/>";
		$this->Config['allow_hooks'] = TRUE;
	}

}

?>
