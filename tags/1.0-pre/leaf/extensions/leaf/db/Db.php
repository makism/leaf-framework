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
 */
define('DB_RESULT_CREATION_PREEMPTIVE', "PREEMPTIVE");

/**
 *
 *
 */
define('DB_RESULT_CREATION_ON_DEMAND', "ON_DEMAND"); 


/**
 *
 *
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db extends leaf_Extension {

	/**
	 * Configuration file.
	 *
	 * @var	string
	 */
	protected $configFile = "database.php";
	
	/**
	 * Factory class used to produce the connections.
	 *
	 * @var	object Db_Factory
	 */
	private $factory = NULL;
	
	/**
	 * Holds all the database connections.
	 *
	 * That is instances of the class Db_Frontend,
	 * using a specific backend driver.
	 *
	 * @var	array
	 */
	private $pool = array();
	
	
/*****************************************************************************
************************************************************ INHERITED METHODS
******************************************************************************/

	/**
	 *
	 *
	 * @return	void
	 */
    public function init()
	{
		$this->factory = Db_Factory::getInstance();
    }
	
	/**
	 *
	 *
	 *
	 */
	public function php_dependancies()
	{
		return array("spl", "mysql");
	}
    
	/**
	 *
	 *
	 * @return	void
	 */
    public function handle_pkg_classes()
	{
        require_once $this->extensionBaseDir . "Db_Factory.php";
		require_once $this->extensionBaseDir . "Db_Frontend.php";
        require_once $this->extensionBaseDir . "Db_ActiveRecord.php";
		require_once $this->extensionBaseDir . "Db_Metadata_Field.php";
		require_once $this->extensionBaseDir . "Db_Metadata_Table.php";
		require_once $this->extensionBaseDir . "Db_Metadata_Database.php";
		require_once $this->extensionBaseDir . "backends/mysql.php";
		require_once $this->extensionBaseDir . "Db_Result.php";
		require_once $this->extensionBaseDir . "Db_ResultSet.php";
    }
	
	/**
	 *
	 *
	 * @return	string
	 */
	public function __toString()
	{
	
	}
	
/*****************************************************************************
**************************************************************** OTHER METHODS
******************************************************************************/
	
	/**
	 * Returns a previously created connection.
	 *
	 * @param	string	$prof_id
	 * @return	void
	 */
	public function __get($prof_id)
	{
		if (array_key_exists($prof_id, $this->pool))
			return $this->pool[$prof_id];
	}
	
	/**
	 *
	 *
	 * @param	string	$conn_id
	 * @param	object	$conn
	 * @return	void
	 */
	protected function __set($conn_id, $conn)
	{
		return;
	}
	
	/**
	 *
	 *
	 * @param	string	$profile_id
	 * @param	array	$profile
	 * @return	object Db_Frontend
	 */
	public function newProfile($profile_id, array $profile)
	{
		if (!array_key_exists($profile_id, $this->configurationOptions['profiles'])) {
			if (array_key_exists("backend", $profile)	&&
				array_key_exists("username", $profile)	&&
				array_key_exists("password", $profile)	&&
				array_key_exists("hostname", $profile)
			) {
				$this->configurationOptions['profiles'][$profile_id] =
					$profile;
				
				return $this->factory->connect($profile_id);
			}
		}
	}
	
	/**
	 * 
	 *
	 * @param	string	$profile_id
	 * @param	boolean	$populateMetadata
	 * @return	object Db_Frontend
	 */
	public function connect($profile_id, $populateMetadata=TRUE)
	{
		if (array_key_exists($profile_id, $this->configurationOptions['profiles'])) {
			$prof = $this->configurationOptions['profiles'][$profile_id];
			$prof['name'] = $profile_id;
			$conn = $this->factory->factory($prof, $populateMetadata);
			
			$this->pool[$profile_id] = $conn;
			
			return $conn;
		}
	}
	
	/**
	 * Removes a connection instance from the pool.
	 *
	 * @param	object Db_Frontend $obj
	 * @return	void
	 */
	public function removeFromPool($obj)
	{
		if ($obj instanceof Db_Frontend) {
			$profile_name = $obj->getProfileName();
			if (array_key_exists($profile_name, $this->pool)) {
				unset ($this->pool[$profile_name]);
			}
		}
	}
	
	/**
	 * Returns all the available profiles.
	 *
	 * @return	array
	 */
	public function getProfiles()
	{
		return $this->configurationOptions['profiles'];
	}
	
	/**
	 *
	 *
	 * @param	string	$option
	 * @return	array|string|NULL
	 */
	public function getConfig($option=NULL)
	{
		if ($option==NULL) {
			return $this->configurationOptions['general'];
		} else {
			if (array_key_exists($option, $this->configurationOptions['general'])) {
				return $this->configurationOptions['general'][$option];
			}
		}
		
		return NULL;
	}
	
}

