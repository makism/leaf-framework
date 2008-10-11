<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */
 
 
/**
 * Database Metadata
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db_Metadata_Database {

	/**
	 *
	 *
	 * @var	array
	 */
	private $keys = NULL;

	/**
	 *
	 *
	 * @var	array
	 */
	private $tables = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $databaseName = NULL;

	
	/** 
	 *
	 *
	 * @param	string		$dbname
	 * @param	array		$tables
	 * @param	array|NULL	$keys
	 * @return	void
	 */
	public function __construct($databaseName, array $tables=NULL, array $keys=NULL)
	{
		$this->databaseName = $databaseName;
		$this->tables		= $tables;
		$this->keys			= $keys;
	}
	
	/**
	 *
	 *
	 * @param	string	$tblName
	 * @return	object Db_Metadata_Table|NULL
	 */
	public function getTable($tblName)
	{
		if (array_key_exists($tblName, $this->tables)) {
			return $this->tables[$tblName];
		} else { 
			return NULL;
		}
	}
	
	/**
	 *
	 *
	 * @return	object Db_Metadata_Table|NULL
	 */
	public function getTables()
	{
		return $this->tables;
	}
	
	/** 
	 *
	 *
	 * @return	void
	 */
	private function __clone()
	{
		return;
	}
	
	/** 
	 *
	 *
	 * @return	string
	 */
	public function __toString()
	{
		return $this->databaseName;
	}

}
