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
 * Table Metadata
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 * @see			ArrayObject (SPL)
 * @see			Iterator (SPL)
 */
class Db_Metadata_Table implements Iterator {

	/**
	 *
	 *
	 * @var	array
	 */
	private $fields = NULL;
	
	/**
	 *
	 *
	 * @var	array
	 */
	private $primaryKeys = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $tableName = NULL;

	
	/** 
	 *
	 *
	 * @param	string	$tableName
	 * @param	array	$fields
	 * @return	void
	 */
	public function __construct($tableName, array $fields)
	{
		$this->tableName = $tableName;
		$this->fields = $fields;
		
		foreach ($this->fields as $field) {
			if ($field->isPrimaryKey())
				$this->primaryKeys [] = $field->getName();
		}
	}
	
	/**
	 *
	 *
	 * @return	array|NULL
	 */
	public function getPrimaryKeys()
	{
		return $this->primaryKeys;
	}
	
	/** 
	 *
	 *
	 * @return	string
	 */
	public function getTableName()
	{
		return $this->tableName;
	}
	
	/**
	 *
	 *
	 * @return	integer
	 */
	public function numFields()
	{
		return sizeof($this->fields);
	}
	
	/**
	 *
	 *
	 * @param	string	$idx
	 * @return	object Db_Metadata_Field|NULL
	 */
	public function getField($idx)
	{
		if (array_key_exists($idx, $this->fields))
			return $this->fields[$idx];
	}
	
	/**
	 *
	 *
	 * @return	object Db_Metadata_Field
	 */
	public function getFields()
	{
		return $this->fields;
	}
	
	/** 
	 *
	 *
	 * @see		ArrayObject (SPL)
	 * @return	object ArrayObject
	 */
	public function getFieldsAsArray()
	{
		return new ArrayObject($this->fields);
	}
	
	/** 
	 *
	 * @see		Iterator (SPL)
	 * @return	void
	 */
	public function rewind()
	{
		reset($this->fields);
	}
	
	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	boolean
	 */
	public function valid()
	{
		return ($this->current()!==FALSE);
	}
	
	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	string
	 */
	public function key()
	{
		return key($this->fields);
	}
	
	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	object Db_Metadata_Field
	 */
	public function current()
	{
		return current($this->fields);
	}
	
	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	void
	 */
	public function next()
	{
		next($this->fields);
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
		return $this->tableName;
	}

}
