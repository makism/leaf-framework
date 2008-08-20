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
 *
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db_Result implements ArrayAccess, Iterator {

	/**
	 *
	 *
	 * @var	array
	 */
	private $record = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $tblName = NULL;
	
	/**
	 *
	 *
	 * @var	object Db_Backend
	 */
	private $backend = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $whereStmt = NULL;

	
	/**
	 *
	 *
	 * @param	object Db_Backend	$backend
	 * @param	array			$record
	 * @return	void
	 */
	public function __construct(&$backend, $tblName, array $record)
	{
		$this->backend  = $backend;
		$this->record	= $record;
		$this->tblName	= $tblName;
		
		for($i=0; $i<sizeof($record); $i++) {
			list($field, $value) = each($record);
			
			if ($value=="")
				$this->whereStmt .= " {$field} IS NULL ";
			else
				$this->whereStmt .= " {$field} = \"" . $this->backend->escapeString($value) . "\"";
			
			if ($i<sizeof($record)-1)
				$this->whereStmt .= " AND ";
		}
		
	}
	
	/**
	 *
	 *
	 *
	 */
	private function createResult()
	{
	
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
	
	}
	
	/**
	 *
	 *
	 *
	 */
	public function __sleep()
	{
		return array("record");
	}
	
	/**
	 *
	 *
	 *
	 */
	public function __wakeup()
	{
	
	}
	
	/**
	 *
	 *
	 *
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function __get($offset)
	{
		if ($this->offsetExists($offset))
			return $this->record[$offset];
	}
	
	/**
	 *
	 *
	 * @param	string	$offset
	 * @param	mixed	$value
	 * @return	void
	 */
	public function __set($offset, $value)
	{
		if ($this->offsetExists($offset))
			$this->record[$offset] = $value;
	}
	
	/**
	 *
	 *
	 * @param	string	$offset
	 * @return	boolean
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->record);
	}
	
	/**
	 *
	 *
	 * @param	string	$offset
	 * @param	string	$value
	 * @return	void
	 */
	public function offsetSet($offset, $value)
	{
		return $this->__set($offset, $value);
	}
	
	/** 
	 *
	 *
	 * @param	string	$offset
	 * @return	void
	 */
	public function offsetUnset($offset)
	{
		return;
	}
	
	/**
	 *
	 *
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function offsetGet($offset)
	{
		return $this->__get($offset);
	}
	
	/**
	 *
	 *
	 *
	 * @return	object Db_Metadata_Table
	 */
	public function tableMetadata()
	{
		return $this->backend->getMetadata($this->tblName);
	}
	
	/**
	 *
	 *
	 * @return	object Db_Metadata_Field
	 */
	public function fieldMetadata($fieldName)
	{
		return $this->backend->getMetadata($this->tblName)->getField($fieldName);
	}
	
	/** 
	 *
	 *
	 * @return	void
	 */
	public function rewind()
	{
		reset($this->record);
	}
	
	/** 
	 *
	 *
	 *
	 * @return	string
	 */
	public function key()
	{
		return key($this->record);
	}
	
	/** 
	 *
	 *
	 *
	 * @return	string
	 */
	public function current()
	{
		return current($this->record);
	}
	
	/** 
	 *
	 *
	 *
	 * @return	void
	 */
	public function next()
	{
		next($this->record);
	}
	
	/** 
	 *
	 *
	 *
	 * @return	boolean
	 */
	public function valid()
	{
		return ($this->current()!==FALSE);
	}
	
	/**
	 *
	 *
	 *
	 * @return	 boolean
	 */
	public function delete()
	{
	
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function update()
	{
		$query = "UPDATE {$this->tblName} SET ";
		
		for($i=0; $i<sizeof($this->record); $i++) {
			list($field, $value) = each($this->record);
			
			if ($value=="")
				$query .= " {$field} = NULL ";
			else 
				$query .= " {$field} = \"" . $value . "\"";
			
			if ($i<sizeof($this->record)-1)
				$query .= ", ";
		}
		
		$query .= " WHERE " . $this->whereStmt;
		
		return $this->backend->execute($query);
	}
	
	/**
	 *
	 *
	 * @param	object Db_Result	$new
	 * @return	boolean
	 */
	public function replace(Db_Result $newResult)
	{
	
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function duplicate()
	{
	
	}

}

