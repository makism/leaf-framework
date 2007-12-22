﻿<?php

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
        // Call the parent`s contructor.
		parent::__construct();
		
		// Parameters passed to the Db library
		// (a) define a db profile, and
		// (b) we demand to connect as soon as the profile has been binded.
		/*$opts = array (
		  "profile"       => "sample",
		  "auto_connect"  => true
		);*/
		
        // Request for database support based on these parameters.
		//$this->Load->library("Db", $opts);
		
		// The above lines are exactly the same as calling consequently:
		// 1. $this->Load->library("Db");
		// 2. $this->Db->bind("sample");
		// 3. $this->Db->sample->connect();
		//
		// The lines 2 & 3 could also be written as:
		// 2. $db = $this->Db->bind("sample");
		// 3. $db->connect();
        

        // Load the Sample Model.
        $this->Load->model("SampleModel");
        
        // This could be achieved also:
        // 1. $this->Load->model("SampleModel", array("bindName"=>"sample"));
        
		// Include some required plugins.
		$this->Load->plugin("url");
		
		// Disable Hooks
		$this->Config['allow_hooks'] = FALSE;
	}

	public function index()
	{
		// Populate the data array.
		$data['title'] = $this->sample->getPageTitle();
		$data['desc'] = "This is a test View, displayed by the Sample Application`s Controller.";
		
        // Print a welcome message.
        $this->View->render("main", $data);
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
