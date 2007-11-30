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
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 * </ol>
 */
final class leaf_Db_Factory extends leaf_Base {

    const LEAF_REG_KEY = "db_factory";
    
    const LEAF_CLASS_ID = "LEAF_DB_FACTORY-1_0_dev";
    
    /**
     * Currently supported database backends.
     * 
     * For the time being, we support the classic MySQL extension.
     * "mysqli", "sqlite2" and "pdo" will follow.
     * 
     * @var array
     */
    private $supportedBackends = array("mysql");
    
    /**
     * An array holding all the different connections. 
     * 
     * @var array
     */
    private $connectionsPool = array();
    
    
    /**
     * Calls the parent constructor.
     * 
     * @return  void
     */
    public function __construct()
    {
    	parent::__construct();
    }
    
    /**
     * 
     * @return
     */
    public function factoryBackend($target)
    {
    	if (in_array($this->supportedBackends)) {
    		    		
    	}
    }
    
    /**
     * 
     * @param   string  $alias
     * @return  mixed
     */
    public function getConnection($alias)
    {
    	
    }
    
    public function __toString()
    {
    	
    }
	
}

?>