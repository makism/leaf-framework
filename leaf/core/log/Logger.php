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
 */
define('LEVEL_ALL', 1);

/**
 *
 */
define('LEVEL_DEBUG', 2);

/**
 *
 */
define('LEVEL_WARNING', 4);

/**
 *
 */
define('LEVEL_INFO', 8);

/**
 *
 */
define('LEVEL_ERROR', 16);


/**
 * Handles all requests for logging.
 *
 * @package     leaf
 * @subpackage  core.log
 * @author	Avraam Marimpis <makism@users.sf.net>
 * @version	SVN: $Id$
 * @method	void log()
 *		     log(string message)
 *		     log(Exception e)
 *	             log(int level, string message)
 *		     log(int level, string message, string fileName)
 *		     log(int level, string message, string fileName, string className)
 *		     log(int level, Exception e)
 *	Handles to log a message.
 */
final class leaf_Logger extends leaf_Base {

    const LEAF_REG_KEY = "Log";
    
    const LEAF_CLASS_ID = "LEAF_LOGGER-1_0_dev";


	/**
     * Current logging level threshold.
     *
     * @var int
     */
	private $threshold= NULL;
	
	/**
     * Logging levels.
     *
     * @var array
     */
	private $levels   = array(
		0 => "None",
		LEVEL_ALL => "All",
		LEVEL_DEBUG => "Debug",
		LEVEL_WARNING => "Warning",
		LEVEL_INFO => "Info",
		LEVEL_ERROR => "Error"
	);
	
	/**
	 * Available backends.
	 *
	 * @var	array
	 */
	private $backends = array ("Heap");
	
	/**
	 * The backend that supports the logging facility.
	 *
	 * @var	object	leaf_Log
	 */
	private $backend = NULL;
	
	
	/**
     *
	 * @return	void
	 */
	public function __construct()
	{
		$this->threshold = LEVEL_ALL;
		
		require_once LEAF_BASE . "core/log/backend/Heap.php";
		$this->backend = new leaf_Logger_Heap();
	}
	
	/**
	 * Logs a message or an exception, may also specify level and other information.
	 *
	 * @param	string	$method
	 * @param	array	$args
	 * @return	void
	 * @method	void log()
	 *				 log(string message)
	 *				 log(Exception e)
	 *				 log(int level, string message)
	 *				 log(int level, string message, string fileName)
	 *				 log(int level, string message, string fileName, string className)
	 *				 log(int level, Exception e)
	 */
	public function __call($method, $args)
	{
		if ($method=="log") {
			$size = sizeof($args);
			$packet = array();
			
			if ($size==1) {
				$m = $args[0];
				
				$packet['level'] = LEVEL_ALL;
				
				if (!is_object($m)) {
					$packet['message'] = $m;
					$this->backend->setPackLog($packet);
				}
				
				$this->backend->saveLog();
			}
		}
	}
	
	/**
	 * Sets the threshold level.
	 *
	 * @param	int	$level
	 * @return	void
	 */
	public function setLevel($level)
	{
		if (array_key_exists($level, $this->levels))
			$this->threshold = $level;
	}
	
	/**
	 * Returns the current threshold level.
	 *
	 * @return	integer
	 */
	public function getLevel()
	{
		return $this->threshold;
	}
	
	/**
	 * Terminates the logging.
	 *
	 * @return	void
	 */
	public function end_flush()
	{
		if ($this->backend->supportsFlush())
			$this->backend->end_flush();
	}
	
	/**
	 *
	 *
	 * @return object leaf_Log
	 */
	public function getBackend()
	{
		return $this->backend;
	}
	
	/**
	 *
	 *
	 */
	public function getBuffer()
	{
		
	}
	
	public function __toString()
	{
		return __CLASS__ . " (Handles your needs for logging.) [{$this->backend}]";
	}

}

