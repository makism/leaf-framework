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
 * Specifies the methods that all the Backends drivers must
 * implement.
 * 
 * @package     leaf
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 * </ol>
 */
abstract class leaf_Db_Backend extends leaf_Base {
    
	const LEAF_REG_KEY = "db_backend";
    
    const LEAF_CLASS_ID = "LEAF_DB_BACKEND-1_0_dev";
    
    /**
     * 
     * 
     * @var object leaf_Db_ActiveRecord
     */
    private $activeRecord = NULL;
	
	
	/**
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 
	 *
	 */
	public function __destruct()
	{
	    
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	abstract public function connect();
	
	/**
	 * 
	 *
	 * @return boolean
	 */
	abstract public function disconnect();
	
	/**
	 * 
	 *
	 * @param  string  $dbName
	 */
	abstract public function selectDb($dbName);
	
	/**
	 * 
	 * 
	 */
	abstract public function enableActiveRecord();
	
	/**
	 * 
	 * 
	 */
	abstract public function disableActiveRecord();
	
}

?>
