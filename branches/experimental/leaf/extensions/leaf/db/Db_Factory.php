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
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db_Factory {

	/**
	 * Supported (php) database drivers and implemented
	 * backend classes.
	 *
	 * @var	array
	 */
	private $backends = array ();
	
	/**
	 *
	 *
	 * @var object Db_Factory
	 */
	private static $instance = NULL;
	
	
	/**
	 * 
	 *
	 * @return	void
	 */
	private function __construct()
	{
		$checkBackends = array("mysql", "mysqli");
		foreach ($checkBackends as $backend) {
			if (extension_loaded($backend))
				array_push($this->backends, $backend);
		}
	}
	
	/**
	 *
	 *
	 *
	 * @return	object Db_Factory
	 */
	public static function getInstance()
	{
		if (self::$instance==NULL)
			self::$instance = new DB_Factory();
			
		return self::$instance;
	}
	
	/**
	 *
	 *
	 * @param	array	$profile
	 * @param	boolean	$populateMetadata
	 * @return	object Db_Frontend
	 */
	public function factory($profile, $populateMetadata)
	{
		if (in_array($profile['backend'], $this->backends)) {
			$backendName= "Db_Backend_" . $profile['backend'];
			$instance	= new $backendName($profile, $populateMetadata);
			return $instance;
		}
	}

}
