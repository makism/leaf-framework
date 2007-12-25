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
 * Handles all requests for logging.
 *
 * @package     leaf
 * @subpackage  core.log
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version	    $Id$
 * @method		void log()
 *					 log(string message)
 *					 log(Exception e)
 *					 log(int level, string message)
 *					 log(int level, string message, string fileName)
 *					 log(int level, string message, string fileName, string className)
 *					 log(int level, Exception e)
 */
final class leaf_Logger extends leaf_Base {

    const LEAF_REG_KEY = "Log";
    
    const LEAF_CLASS_ID = "LEAF_LOGGER-1_0_dev";


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
	 * @var	array
	 */
	private $backends = array ("Heap", "File");
	
	
	/**
     *
	 * @return	void
	 */
	public function __construct()
	{

	}
	
	/**
	 *
	 *
	 * @param	string	$method
	 * @param	array	$args
	 * @return	boolean
	 */
	public function __call($method, $args)
	{
	
	}
	
	public function __toString()
	{
		return __CLASS__ . " (Handles your needs for logging.)";
	}

}

?>
