<?php

/**
 * 
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @package     extensions
 * @subpackage  leaf.performance
 */
class Performance extends leaf_Extension {

    /**
     * 
     * 
     *
     * @var array
     */
    private $points = array();
    
    /**
     * 
     * 
     * @var array
     */
    private $groups = array();
    
    /**
     * 
     * 
     * @var array
     */
    private $groupsDescriptions = array();
    

    /**
     * 
     * 
     * @return  void
     */
    public function init()
    {
        return;
    }
    
    /**
     * 
     * 
     * @param   string  $offset
     * @return  object Performance_Record|NULL
     */
    public function __get($offset)
    {
        if (array_key_exists($offset, $this->points))
            return $this->points[$offset];
            
        return NULL;
    }
    
    /**
     * 
     * 
     * @param   string    $offset
     * @param   string    $desc
     * @return  object Performance_Record|NUL
     */
    public function add($offset, $desc=NULL)
    {
        if (array_key_exists($offset, $this->points)==FALSE) {
            $this->points[$offset] = new Performance_Record($offset, NULL, $desc);
            return $this->points[$offset];
        }
        
        return NULL;
    }
    
    /**
     * 
     * 
     * @param   string  $offset
     * @return  void
     */
    public function remove($offest)
    {
        if (array_key_exists($offset, $this->points))
            unset($this->points[$offset]);
    }
    
    /**
     * 
     * 
     * @param   string  $offset
     * @param   string  $group
     * @param   string  $desc
     * @return   void
     */
    public function addToGroup($offset, $group, $desc=NULL)
    {
        if (array_key_exists($group, $this->groups)) {
            if (array_key_exists($offset, $this->groups[$group])==FALSE) {
                $this->groups[$group][$offset] = new Performance_Record($offset, $group, $desc);
                return $this->groups[$group][$offset];
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $offset
     * @param   string  $group
     * @return  void
     */
    public function removeFromGroup($offset, $group)
    {
        if (array_key_exists($group, $this->groups)) {
            if (array_key_exists($offset, $this->groups[$group])) {
                unset ($this->groups[$group][$offset]);
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $name
     * @param   string  $desc
     * @return  void
     */
    public function createGroup($name, $desc=NULL)
    {
        if (array_key_exists($name, $this->groups)==FALSE) {
            $this->groups[$name] = array();
            $this->groupsDescriptions[$name] = $desc;
        }
    }
    
    /**
     * 
     * 
     * @return  string
     */
    public function __toString()
    {
        return;
    }
    
    /**
     * 
     * 
     *
     * @return  void
     */
    public function handle_pkg_classes()
    {
        require_once $this->extensionBaseDir . "Performance_Record.php";
    }
    
}

