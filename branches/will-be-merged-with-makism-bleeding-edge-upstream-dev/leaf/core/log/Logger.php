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
 * @subpackage  core.log
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version	    $Id$
 * @method		void log() log(string message) log(string level, string message) log(string level, string message, string fileName) log(string level, string message, string fileName, string className) Handles to log a message. Αναλαμβάνει να γράψει ένα μήνυμα.
 * @todo
 * <ol>
 *  <li>Possible implementation for logging in a database.</li>
 * </ol>
 */
final class leaf_Logger extends leaf_Base implements leaf_Log {

    const LEAF_REG_KEY = "logger";
    
    const LEAF_CLASS_ID = "LEAF_LOGGER-1_0_dev";
    

	/**
     *
     *
     * @var string
     */
	private $filename= NULL;
	
	/**
     *
     *
     * @var string
     */
	private $stampPat= NULL;
	
	/**
     *
     *
     * @var array
     */
	private $buffer	 = NULL;
	
	/**
     *
     *
     * @var int
     */
	private $threshold= NULL;
	
	/**
     *
     *
     * @var array
     */
	private $levels   = array("All", "Debug", "Warning", "Info", "None");
	
	/**
     *
     *
     * @var resource
     */
	private $fp = NULL;
	
	
	/**
	 * Begins the logging procedures, like file locking and filename scheming.
     *
	 * @param	boolean	$buffer
	 * @return	void
	 */
	public function __construct($buffer=false)
	{
	    /*
	     * In case this is a development release, capture all errors and
	     * messages.
	     */
	    /*if (LEAF_REL_STATUS=='DEV')
            $this->threshold = "All";
        else
            $this->threshold = Registry::instance()->config['log_level'];*/
        $this->threshold = $this->Config['log_level'];

        /*
         * Output filename.
         */
        $this->filename = LEAF_VAR . 'logs/' . date("d_m_Y") . ".log";
        
        $this->fp = fopen($this->filename, "a");
        flock($this->fp, LOCK_EX);
        
        $this->log("leaf Framework (" . LEAF_REL_STATUS . ") Inited on " . date("r"));
        $this->log(" -> leaf has been checked, and found sanile!");
        $this->log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
        
        /*$this->log("Debug", "Registry has been instantiated");
        $this->log("Debug", "Config has been instantiated");
        $this->log("Debug", "Logger just instantiated");*/
	}
	
	/**
	 * Flushes (empties) the internal buffer.
     *
     * If the first parameter is given and is set the
     * boolean "true", then the method will return the
     * buffer`s contents.
     *
	 * @param	boolean	$return
	 * @return	array|NULL
	 */
	public function flush($return=false)
	{
		if (sizeof($this->buffer)>0) {
			$tmp = $this->buffer;
			unset($this->buffer);
			
			if ($return)
				return $tmp;
				
		}
		
		return NULL;
	}
	
	/**
	 * Flushes the internal buffer, and releases all locks on the log files.
     *
	 * @return	void
	 */
	public function end_flush()
	{
	    $this->flush();
	    fwrite($this->fp, "\n");
	    flock($this->fp, LOCK_UN);
	    fclose($this->fp);
	}
	
	/**
	 * Set a timestamp pattern.
     *
	 * @param	string	$pat
	 * @return	void
	 */
	public function setTimeStampPattern($pat)
	{
	    $this->stampPat = $pat;
	}

	/**
	 * Set the level of errors to capture.
	 *
	 * @param	string	$filterLevel
	 * @return	boolean
	 */
	public function setLevel($filterLevel)
	{
		if (array_key_exists($filterLevel, $this->levels)) {
		    $this->threshold = $filterLevel;
		    return true;
		} else {
		    return false;
		}
	}

	/**
	 * __call
	 *
	 *
	 * @param	string	$method
	 * @param	array	$args
	 * @return	void
	 */
	public function __call($method, $args)
	{
		if ($method=="log") {
		    $s = sizeof($args);
		    
		    if ($s>0) {
		        if ($s==1) {
		            $msg = $args[0];
		            fwrite($this->fp, $msg . "\n");
		        } else {
		            
		            if (in_array($args[0], $this->levels)==FALSE)
		                ;
		            
		            $level = strtoupper($args[0]);
		            
		            if ($this->threshold==$level || $this->threshold=="All") {
			            $msg   = $args[1];
			            $file  = ($s==3)
			                        ? "(file: " . $args[2] . ")"
			                        : NULL;
	
	    		        fwrite($this->fp, "[{$level}] {$msg} {$file}" . "\n");
		            }
		        }
		    }
		}
	}

}

?>
