<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small footprint and
 * easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο, μικρό σε μέγεθος
 * και εύκολα επεκτάσιμο.<br>
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @package		leaf
 * @subpackage	core
 * @version		1.0-dev
 * @filesource
 */


/**
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @method		void log() log(string message) log(string level, string message) log(string level, string message, string fileName) log(string level, string message, string fileName, string className) Handles to log a message. Αναλαμβάνει να γράψει ένα μήνυμα.
 * @todo
 * <ol>
 *  <li>Πιθανή υποστήριξη για καταχώρηση των σφαλμάτων του level "Error"
 *  σε βάση δεδομένων ή κάποια e-mail διεύθυνση.</li>
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
	 * Class constructor
	 *
	 *
	 * @param	boolean	$buffer
	 * @return	void
	 */
	public function __construct($buffer=false)
	{
	    /*
	     * In case this is a development release, capture all errors and
	     * messages.
         *
	     * Σε περίπτωση που πρόκειται για έκδοση υπό-ανάπτυξη, θα καταγράψουμε
	     * όλα τα σφάλματα και μηνύματα.
	     */
	    /*if (LEAF_REL_STATUS=='DEV')
            $this->threshold = "All";
        else
            $this->threshold = Registry::instance()->config['log_level'];*/
        $this->threshold = $this->config['log_level'];

        /*
         * Output filename.
         *
         * Το αρχείο στο οποίο θα γράψουμε.
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
	 * flush
	 * 
	 * 
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
	 * end_flush
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
	 * setTimeStampPattern
	 * 
	 * @param	string	$pat
	 * @return	void
	 */
	public function setTimeStampPattern($pat)
	{
	    $this->stampPat = $pat;
	}

	/**
	 * setLevel
	 *
	 * Set the level of errors to capture.<br>
	 * Θέτει το επίπεδο των σφαλμάτων που θα καταχωρήσει.
	 * 
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
