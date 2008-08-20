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
class Db_ActiveRecord  {

    /**
     * 
     *
     * @var object Db_Frontend
     */
    private $backend = NULL;
    
    /**
     * 
     *
     * @var object Db_Metadata_Table
     */
    private $metadata = NULL;
    
    /**
     * 
     * 
     * @var	array
     */
    private $data = NULL;
    
    /**
     * 
     * 
     * @var	string
     */
    private $query = NULL;
    

    /**
     * 
     *
     * @param	object Db_Frontend $backend
     * @return	void
     */
	public function __construct(&$backend)
	{
        $this->backend = $backend;
        
        $this->metadata= $this->backend->getMetadata(
            $this->backend->getDefaultTable()
        );
        
        $this->query = "INSERT INTO {$this->backend->getDefaultTable()}(";

        $arr = $this->metadata->getFieldsAsArray();
        foreach ($arr as $field) {
            $fieldName = $field->getName();
            
            if (($def=$field->getDefaultValue())==NULL) {
                //if ($field->allowsNull())
                    $this->data[$fieldName] = NULL;
            } else {
                $this->data[$fieldName] = $def;
            }
                
            $this->query .= $fieldName;
            if (next($arr)!==FALSE)
                 $this->query .= ", ";
        }
        
        $this->query .= ") VALUES (";
        $this->query .= str_repeat("?,", $arr->count()-1);
        $this->query .= "?)";
        
        $this->metadata->rewind();
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	public function valid()
	{
        $arr = $this->metadata->getFieldsAsArray();
        foreach ($this->data as $field => $data) {
            $fieldName = $field->getName();
            $meta = $this->metadata->getField($fieldName);
        
            if ($meta->isAutoIncrement()==FALSE) {
                if (empty($this->data[$fieldName]) && $meta->allowsNull()==FALSE)
                    return FALSE;
            }
        }
        
	    return TRUE;
	}
	
	/**
	 * 
	 * 
	 *
	 * @param	string	$fieldName
	 * @param	mixed	$value
	 * @param	boolean
	 */
	public function __set($fieldName, $value)
	{
	    if (array_key_exists($fieldName, $this->data)) {
	        $meta = $this->metadata->getField($fieldName);
	        
	        if ($meta->isAutoIncrement()==FALSE) {
	            
	            if ($meta->getSize()!=NULL) {
	               if (strlen($value)>$meta->getSize()) {
	                   $value = substr($value, 0, $meta->getSize()-1);	                   
	               }
	            }
	            
	            if ($meta->getType()=="text" || $meta->getType()=="varchar") {
	                $this->data[$fieldName] = $this->backend->escapeString(trim($value));
	                
	            }
	            
	            if ($meta->getType()=="enum") {
	                if (in_array($value, $meta->getValueRange()))
	                   $this->data[$fieldName] = $value;
	                else
	                   return FALSE;
	            }
	            
	            if ($meta->getType()=="set") {
	                foreach ($value as $Value) {
	                    if (!in_array($Value, $meta->getValueRange()))
	                       return FALSE;
	                }
	                
	                $this->data[$fieldName] = implode(",", $value);
	            }
	            
	            // add numeric types...
	            
	            return TRUE;
	        }
	    }
	    
	    return FALSE;
	}
	    
	
	/**
	 * 
	 * 
	 * @return	void
	 */
	public function save()
	{
	    if ($this->backend!=NULL) {
	        $this->backend->preparedStatement($this->query, array_values($this->data));
	    }
	}


}

