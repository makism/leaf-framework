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
 * Field Metadata
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db_Metadata_Field {

	/** 
	 *
	 *
	 * @var	array
	 */
	private $metadata = NULL;


	/** 
	 *
	 *
	 * @param	array	$metadata
	 * @return	void
	 */
	public function __construct(array $metadata)
	{
		$this->metadata = $metadata;
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function isPrimaryKey()
	{
		return $this->metadata['primary'];
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function isUniqueKey()
	{
		return $this->metadata['unique'];
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function isKey()
	{
		return $this->metadata['key'];
	}
	
	/**
	 *
	 *
	 * @return	string
	 */
	public function getType()
	{
	return $this->metadata['type'];
	}
	
	/**
	 *
	 *
	 * @return	string
	 */
	public function getName()
	{
		return $this->metadata['name'];
	}
	
	/**
	 *
	 *
	 * @return	mixed
	 */
	public function getDefaultValue()
	{
		return $this->metadata['defaultValue'];
	}
	
	/**
	 * 
	 *
	 * @return	boolean
	 */
	public function allowsNull()
	{
		return $this->metadata['allowsNull'];
	}
	
	/**
	 *
	 *
	 * @return	integer
	 */
	public function getSize()
	{
		return $this->metadata['size'];
	}
	
	/** 
	 *
	 *
	 * @return	boolean
	 */
	public function isAutoIncrement()
	{
		return $this->metadata['autoIncrement'];
	}
	
	/**
	 *
	 *
	 *
	 */
	public function getValueRange()
	{
		return $this->metadata['valueRange'];
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
		return $this->getName();
	}
	
}
