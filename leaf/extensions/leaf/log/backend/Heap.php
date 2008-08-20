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
 * The logging is done using an internal buffer.
 * The buffer is implemented by an array.
 *
 * @package     extensions
 * @subpackage  leaf.log.backend
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version 	SVN: $Id$
 */
class leaf_Logger_Heap extends leaf_Log {

	/**
	 * A stack with all the logged messages.
	 *
	 * @var	array
	 */
	private $stack = array();
	
	/**
	 *
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 
	 *
	 * @return void
	 */
	public function saveLog()
	{
		
		/*$this->logLevel = $pack['level'];
		$this->logMessage = $pack['message'];
		$this->logFilename = (isset($pack['file'])) ? $pack['file'] : NULL;
		$this->logClassname = (isset($pack['class'])) ?$pack['class'] : NULL;
		$this->logException = (isset($pack['exception'])) ? $pack['exception'] : NULL;
		$this->logStamp = time();*/
		
		$this->clearPackLog();
	}
	
	/**
	 *
	 *
	 *
	 */
	public function getBuffer()
	{
		return;
	}
	
	/**
	 * 
	 *
	 * @return boolean
	 */
	public function supportsFlush()
	{
		return false;
	}
	
	/**
	 *
	 *
	 *
	 */
	public function supportsBuffering()
	{
		return false;
	}
	
	public function __toString()
	{
		return "Heap Backend";
	}

}

