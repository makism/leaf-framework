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
 * @version	    SVN: $Id$
 */
abstract class leaf_Log  {

	/**
	 *
	 *
	 * @var	integer
	 */
	protected $logLevel = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	protected $logMessage = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	protected $logFilename = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	protected $logClassname = NULL;
	
	/**
	 *
	 *
	 * @var object Exception
	 */
	protected $logException = NULL;
	
	/**
	 *
	 *
	 * @var integer
	 */
	protected $logStamp =NULL;
	
	
	/**
	 *
	 *
	 *
	 * @return	void
	 */
	public function __construct()
	{
	
	}
	
	/**
	 *
	 *
	 * @param	array	$pack
	 * @return	void
	 */
	public function setPackLog(array $pack)
	{
		$this->logLevel = $pack['level'];
		$this->logMessage = $pack['message'];
		$this->logFilename = (isset($pack['file'])) ? $pack['file'] : NULL;
		$this->logClassname = (isset($pack['class'])) ?$pack['class'] : NULL;
		$this->logException = (isset($pack['exception'])) ? $pack['exception'] : NULL;
		$this->logStamp = time();
	}
	
	/**
	 * Clears the 
	 *
	 * @return	void
	 */
	protected function clearPackLog()
	{
		$this->logLevel = NULL;
		$this->logMessage = NULL;
		$this->logFilename = NULL;
		$this->logClassname = NULL;
		$this->logException = NULL;
		$this->logStamp =NULL;
	}
	
	/**
	 *
	 *
	 * @return	array
	 */
	public abstract function getBuffer();
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public abstract function supportsFlush();
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public abstract function supportsBuffering();
	
	/**
	 * Dumps the last log
	 *
	 * @return void
	 */
	public abstract function saveLog();
	
	/**
	 *
	 *
	 * @return	string
	 */
	public abstract function __toString();

}

?>
