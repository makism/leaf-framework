<?php

/**
 * 
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @package     extensions
 * @subpackage  leaf.performance
 */
class Performance_Record {
    
    /**
     * 
     * 
     * @var string
     */
    private $description = NULL;
    
    /**
     * 
     * @var string
     */
    private $name = NULL;
    
    /**
     * 
     * @var string
     */
    private $group = NULL;
    
    /**
     * 
     * 
     * @var array
     */
    private $timers = array();
    
    /**
     * 
     * 
     * @var array
     */
    private $counters = array();
    
    /**
     * 
     * 
     * @var array
     */
    private $countersDescriptions = array();
    
    /**
     * 
     * 
     * @var array
     */
    private $memory = array();
    
    
    /**
     * 
     * 
     * @return  void
     */
    public function __construct($name, $group=NULL, $description=NULL)
    {
        $this->name = $name;
        $this->group= $group;
        $this->description = $description;
        
        $this->descriptions = array (
            "timers"    => array(),
            "counters"  => array()
        );
    }
    
    /**
     * 
     * 
     *
     * @param   string  $offset
     * @return  mixed
     */
    public function __get($offset)
    {
        if (array_key_exists($offset, $this->counters))
            return $this->counters[$offset];
    }
    
    /**
     * 
     *
     * @param   string  $offset
     * @param   mixed   $value
     * @return  void
     */
    public function __set($offset, $value)
    {
        if (array_key_exists($offset, $this->counters))
            $this->counters[$offset] = $value;
    }
    
    /**
     * 
     *
     * @param   string  $name
     * @return  void
     */
    public function startTimer($name)
    {
        if (array_key_exists($name, $this->timers)==FALSE) {
            if (!isset($this->timers[$name]['start'])) {
                $this->timers[$name]['start'] = time();
            }
        }
    }
    
    /**
     * 
     * @param   string  $name
     * @return  void
     */
    public function stopTimer($name)
    {
        if (array_key_exists($name, $this->timers)) {
            if (!isset($this->timers[$name]['end'])) {
                $this->timers[$name]['end'] = time();
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $name
     * @return  integer
     */
    public function elapsedTime($name)
    {
        if (array_key_exists($name, $this->timers)) {
            if (isset($this->timers[$name]['start']) &&
                isset($this->timers[$name]['end']))
                {
                    return $this->timers[$name]['end'] - $this->timers[$name]['start'];
                }
        }
    }
    
    /**
     * 
     * 
     * 
     */
    public function addCounter($name, $desc=NULL)
    {
        if (array_key_exists($name, $this->counters)==FALSE) {
            $this->counters[$name] = 0;
            
            if ($desc!=NULL) {
                $this->countersDescriptions[$name] = $desc;   
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $name
     * @return  string
     */
    public function printCounter($name)
    {
        $returnStr = "";
        
        if (array_key_exists($name, $this->counters)) {
            if (array_key_exists($name, $this->countersDescriptions)) {
                $returnStr = $this->countersDescriptions[$name] . ": ";
            }
            
            $returnStr .= $this->counters[$name];
            
            return $returnStr;
        }
    }
    
    /**
     * 
     * 
     * @param   string  $watch
     * @return  void
     */
    public function startMemoryWatcher($watch)
    {
        if (array_key_exists($watch, $this->memory)==FALSE) {
            if (!isset($this->memory[$watch]['start'])) {
                $this->memory[$watch]['start'] = memory_get_usage();
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $watch
     * @return  void
     */
    public function stopMemoryWatcher($watch)
    {
        if (array_key_exists($watch, $this->memory)) {
            if (!isset($this->memory[$watch]['end'])) {
                $this->memory[$watch]['end'] = memory_get_usage();
            }
        }
    }
    
    /**
     * 
     * 
     * @param   string  $watch
     * @return  integer
     */
    public function memoryUsage($watch)
    {
        if (array_key_exists($watch, $this->memory)) {
            if (isset($this->memory[$watch]['start']) &&
                isset($this->memory[$watch]['end']))
                {
                    return $this->memory[$watch]['end'] - $this->memory[$watch]['start'];
                }
        }
    }
    
    /**
     * 
     * 
     * @return  string
     */
    public function __toString()
    {
        return "Performance Mark: {$this->name}";
    }
    
}