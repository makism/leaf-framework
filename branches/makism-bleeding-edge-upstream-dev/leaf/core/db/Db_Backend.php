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
 * Specifies the methods that all the backend drivers must
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
 *  <li>Test.</li>
 * </ol>
 */
abstract class leaf_Db_Backend {
	
    /**
     * 
     * 
     * @var array
     */
    protected $dbProfile = array();
    
    /**
     * 
     * 
     * @var resource
     */
    protected $link = NULL;
    
	
    /**
     *
     * 
     * @return  void
     */
    public function __construct()
    {

    }
	
	/**
	 * 
	 * 
	 * @return void
	 */
	public function __destruct()
	{
	    $this->disconnect();
	}
	
	/**
	 * Creates a link to the database server using
	 * the profile options.
	 * 
	 * @return boolean
	 */
	abstract public function connect();
	
    /**
     * Closes the link.
     *
     * @return  boolean
     */
	abstract public function disconnect();
	
    /**
     * Selects a database.
     *
     * @param   string  $dbName
     * @return  boolean
     */
	abstract public function selectDb($dbName);
	
	/**
	 * 
	 *
	 * @param  string  $select
	 * @return object leaf_Db_ResultSet
	 */
	abstract public function fetch($select);
	
	/**
	 * 
	 *
	 * @param  string  $tbl
	 * @param  string  $order
	 * @param  string  $limit
	 * @return object leaf_Db_ResultSet
	 */
	abstract public function fetchAll($tbl, $order, $limit);
	
	/**
	 * 
	 * 
	 * 
	 */
	abstract public function query($rawQuery);
		
	/**
	 * 
	 * 
	 * @return boolean
	 */
	abstract public function isConnected();
	
}

?>
