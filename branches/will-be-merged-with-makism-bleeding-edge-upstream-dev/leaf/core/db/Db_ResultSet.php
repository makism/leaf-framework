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
 * A seekable table, containing data generated by a select query.
 * 
 * @package     leaf
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 */
class leaf_Db_ResultSet implements ArrayAccess, SeekableIterator {

    /**
     * The result data.
     *
     * @var array
     */
    private $resultData = array();
    
    /**
     * The size of the table.
     * 
     * @var integer
     */
    private $tableSize = NULL;
    
    /**
     * The actual SQL query that produced this table.
     * 
     * @var string
     */
    private $selectQuery = NULL;
    
    /**
     * A unique hash for this result set.
     * 
     * @var string
     */
    private $resultSetId = NULL;
    
    /**
     * Current row pointer.
     * 
     * @var integer
     */
    private $currPointer = 0;
    
    
    /**
     *
     * 
     * @param   string  $query
     * @param   array   $data
     * @return  void
     */
    public function __construct($query, array $data)
    {
        $this->resultData   = $data;
        $this->tableSize    = sizeof($data);
        $this->selectQuery  = $query;
        
        $this->resultSetId = substr(uniqid(md5(microtime())), 0, 8);
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function __destruct()
    {
        return;
    }
    
    /**
     * 
     * 
     * @return  string
     */
    public function getResultSetId()
    {
        return $this->resultSetId;
    }
    
    /**
     * Performs a search in the result set.
     * 
     * @return  boolean
     */
    public function search()
    {
        return;
    }
    
    /**
     * Moves the internal pointer to the last row.
     * 
     * @return  void
     */
    public function last()
    {
        $this->currPointer = $this->tableSize;
    }
    
    /**
     * Moves the internal pointer to the first row.
     * 
     * @return  void
     */
    public function first()
    {
        $this->currPointer = 0;
    }
    
    /**
     * Returns the total number of rows in the current Result Set.
     * 
     * @return  integer
     */
    public function size()
    {
        return $this->tableSize;
    }
    
    /**
     * Checks if there are any rows in the generated table.
     * 
     * @return  boolean
     */
    public function isEmpty()
    {
        return !(boolean)$this->tableSize;
    }
    
    /**
     * Checks if another rows follows after the current one.
     * 
     * @return  boolean
     */
    public function hasNext()
    {
        return ($this->currPointer<$this->tableSize);
    }
    
    /**s t
     * Returns the Result Set as an associative array.
     * 
     * @return  array 
     */
    public function toAssocArray()
    {
        return;
    }
    
    /**
     * Returns the Result Set as an numerical-index array.
     * 
     * @return  array
     */
    public function toArray()
    {
        return;
    }
    
    /**
     * Returns the name of the fields that were involved in this query.
     * 
     * @return  array
     */
    public function fields()
    {
        return;
    }
    
    /**
     * Returns the total number of fields that were involved in this query.
     * 
     * @return  integer
     */
    public function numFields()
    {
        return;
    }
    
################################################################################
#                                             SeekableIterator Inherited Methods
################################################################################
    /**
     * 
     * 
     * @return  array
     */
    public function current()
    {
        return $this->resultData[$this->currPointer];
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function next()
    {
        $this->currPointer++;
    }
    
    /**
     * 
     * 
     * @return  integer|string
     */
    public function key()
    {
        return $this->currPointer;
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function rewind()
    {
        $this->currPointer = 0;
    }
    
    /**
     * 
     * 
     * @return  boolean
     */
    public function valid()
    {
        return array_key_exists($this->currPointer, $this->resultData);
    }
    
    /**
     * 
     * 
     * @return  boolean
     */
    public function seek($index)
    {
        if ($index>=0 && $index<=$this->tableSize) {
            $this->currPointer = $index;
            return true;
        }
        
        return false;
    }
    
################################################################################
#                                                  ArrayAccess Inherited Methods
################################################################################
    /**
     * 
     * 
     * @param   string  $offset
     * @return  boolean
     */
    public function offsetExists($offset)
    {
        
    }
    
    /**
     * 
     * 
     * @return
     */
    public function offsetGet($offset)
    {
        
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        return;
    }
    
    /**
     * 
     *
     * @return  void
     */
    public function offsetUnset($offset)
    {
        return;
    }
    
################################################################################
#                                                                  Magic Methods
################################################################################
    /**
     * Prevent object cloning.
     * 
     * @return  void
     */
    private function __clone()
    {
        return;
    }
    
    /**
     * Return an informational message about the Result Set.
     * 
     * @return  String
     */
    public function __toString()
    {
        return
            "query (`{$this->selectQuery}`) returned {$this->tableSize} rows. " .
            "[id: {$this->resultSetId}]";
    }
    
    
}

?>
