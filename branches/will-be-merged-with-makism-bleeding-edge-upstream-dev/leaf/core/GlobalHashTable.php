<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 *
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 */
final class leaf_GlobalHashTable extends leaf_Base implements ArrayAccess, Iterator {

    const LEAF_REG_KEY = "Global";
    
    const LEAF_CLASS_ID = "LEAF_GLOBALHASHTABLE-1_0_dev";
	
	
	/**
	 *
	 *
	 * @var	array
	 */
	private $table = array();
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $pointer = NULL;
	
	/**
	 *
	 *
	 * @var	integer
	 */
	private $size = 0;

	
	/**
	 *
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct(self::LEAF_REG_KEY);
		
		$this->Load->plugin("global");
	}
	
	/**
	 *
	 *
	 * @param	string	$key
	 * @param	mixed	$value
	 * @return	boolean
	 */
	public function store($key, $value)
	{
	
	}
	
	/**
	 *
	 *
	 * @param	string	$key
	 * @return	mixed
	 */
	public function fetch($key)
	{
	
	}
	
	/**
	 *
	 * @param	string	$key
	 * @return	boolean
	 */
	public function remove($key)
	{
	
	}
	
	/**
	 *
	 *
	 * @return	integer
	 */
	public function size()
	{
	
	}
	
	/**
	 *
	 * @param	string	$key
	 * @return	boolean
	 */
	public function exists($key)
	{
		return array_key_exists($key, $this->table);
	}
	
	/**
	 *
	 *
	 * @see		Iterator
	 * @return	mixed
	 */
    public function current()
    {
        return $this->table[$this->pointer];
    }
    
    /**
     * 
     * 
	 * @see		Iterator
     * @return  void
     */
    public function next()
    {
        
    }
    
    /**
     * 
     * 
	 * @see		Iterator
     * @return  string
     */
    public function key()
    {
        
    }
    
    /**
     * 
     * 
	 * @see		Iterator
     * @return  void
     */
    public function rewind()
    {
        
    }
    
    /**
     * 
     * 
	 * @see		Iterator
     * @return  boolean
     */
    public function valid()
    {
        
    }
    
    /**
     * 
     * 
	 * @see		ArrayAccess
     * @param   string  $offset
     * @return  boolean
     */
    public function offsetExists($offset)
    {
        
    }
    
    /**
     * 
     * 
	 * @see		ArrayAccess
     * @return
     */
    public function offsetGet($offset)
    {
        
    }
    
    /**
     * 
     * 
	 * @see		ArrayAccess
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        
    }
    
    /**
     * 
     * @see		ArrayAccess
     * @return  void
     */
    public function offsetUnset($offset)
    {
		
    }
    
	public function __toString()
	{
		return __CLASS__ . " (A hash table, accessible to all components.)";
	}

}
 
 ?>
 