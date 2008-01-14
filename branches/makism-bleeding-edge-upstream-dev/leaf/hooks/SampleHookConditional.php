<?php

class SampleHookConditional extends leaf_Hook_Conditional {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function run()
	{
		echo "This is a conditional hook (" . __CLASS__ . ").<br/>";
		runHook("testHook");
	}
	
	public function condition()
	{
		return $this->Request->queryStringKeyExists("runConditional");
	}

}

