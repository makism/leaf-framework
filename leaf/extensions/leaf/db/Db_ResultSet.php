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
 * @see			Iterator (SPL)
 */
class Db_ResultSet implements Iterator, ArrayAccess {

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
	private $sqlQuery = NULL;
	
	/**
	 *
	 *
	 * @var	array
	 */
	private $primaryKeys = NULL;
	
	/**
	 *
	 *
	 * @var	array
	 */
	private $results = NULL;
	

	/**
	 *
	 *
	 *
	 * @param	object Db_Backend	$backend
	 * @param	string			$query
	 * @param	array			$results
	 * @return	void
	 */
	public function __construct(&$backend, $query, array $results, array $primaryKeys=NULL)
	{
		$this->backend	= $backend;
		$this->sqlQuery = $query;
		$this->results	= $results;
		$this->primaryKeys = $primaryKeys;
	}
	
	/**
	 *
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
	 *
	 * @return	string
	 */
	public function __toString()
	{
	
	}
	
	public function refresh()
	{
	
	}
	
	public function reset()
	{
	
	}
	
	public function size()
	{
	
	}
	
	public function first()
	{
		return $this[0];
	}
	
	public function last()
	{
		return $this[$this->size()-1];
	}
	
	public function intersect()
	{
	
	}
	
	public function union()
	{
	
	}
	
	public function seek()
	{
	
	}
	
	public function insert()
	{
	    
	}
	
	public function search()
	{
	
	}
	
	public function max($field)
	{
	
	}
	
	public function min($field)
	{
	
	}
	
	public function avg($field)
	{
	
	}
	
	public function sum($field)
	{
	
	}
	
	public function slice($start, $end=NULL)
	{
	
	}
	
	public function random()
	{
	
	}
	
	public function sortBy($sort)
	{
	
	}
	
	public function reverseSortBy($sort)
	{
	
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
		return key($this->results);
	}

	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	object Db_Result
	 */
	public function current()
	{
		return current($this->results);
	}

	/** 
	 *
	 * @see		Iterator (SPL)
	 * @return	void
	 */
	public function rewind()
	{
		reset($this->results);
	}
	
	/**
	 *
	 * @see		Iterator (SPL)
	 * @return	void
	 */
	public function next()
	{
		next($this->results);
	}

	/**
	 *
	 *
	 * @param	string	$offset
	 * @return	boolean
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->results);
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
		return;
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
		return $this->results[$offset];
	}

}
