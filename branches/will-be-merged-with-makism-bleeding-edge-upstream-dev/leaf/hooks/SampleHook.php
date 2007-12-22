<?php

class SampleHook extends leaf_Hook {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function run()
	{
		echo "This is a normal hook (" . __CLASS__ . ").<br/>";
	}

}

?>
