<?php

class Scaffold_Model extends leaf_Model {

	const BIND_NAME = "Scaffold";
	
	/** 
	 *
	 *
	 * @var	array
	 */
	private $profiles = NULL;
	
	
	public function init()
	{
		$profiles = $this->Db->getProfiles();
		
		for($i=0; $i<sizeof($profiles); $i++) {
			$line= each($profiles);
			$conn = $this->Db->connect($line['key']);
			$this->profiles[$line['key']]['db']		= $line[1]['db_name'];
			$this->profiles[$line['key']]['tables']	= $conn->getTables();
		}
	}
	
	public function destroy()
	{
	
	}
	
	/**
	 *
	 *
	 * @return	array
	 */
	public function getProfiles()
	{
		return $this->profiles;
	}

}
