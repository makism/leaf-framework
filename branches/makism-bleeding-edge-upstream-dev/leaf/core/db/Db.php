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
 */
//require_once LEAF_BASE . "core/db/Db_Backend.php";

/**
 *
 *
 */
//require_once LEAF_BASE . "core/db/Db_ActiveRecord.php";

/**
 *
 *
 */
//require_once LEAF_BASE . "core/db/Db_Factory.php";

/**
 *
 * 
 */
define('DB_SCOPE_PROFILE', 1);

/**
 * 
 * 
 */
define('DB_SCOPE_GLOBAL', 2);


/**
 *
 * @package     leaf
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
final class leaf_Db extends leaf_Base {

    const LEAF_REG_KEY = "Db";
    
    const LEAF_CLASS_ID = "LEAF_DB-\$Revision\$";

    
    /**
     * An array holding all the different database connections. 
     * 
     * @var array
     */
    private $connectionPool = array();
    
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
     * 
     * 
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);

    }
    
    /**
     * 
     * 
     * The parameter "scope" specifies the scope in which
     * the defined options will be visible.<br>
     * For example you may specify (<i>in Controller scope</i>):
     * <code>$this->Db->set("encoding", "utf8", DB_SCOPE_PROFILE);</code>
     * this will result in making the options only valid for the
     * current profile you have already bound to.<br>
     * Keep in mind that some of the options have a default scope which
     * cannot be changed.
     * 
     * @param   string  $parameter
     * @param   string  $value
     * @param   integer $scope
     * @return  void
     */
    public function set($parameter, $value, $scope=0)
    {
        
    }
    
    /**
     * 
     * 
     * @param   string  $profileName
     * @param   array   $options
     * @return  void
     */
    public function bind($profileName, array $options=NULL)
    {
        
    }
    
    /**
     * Returns a connection...
     *
     * @return  mixed
     */
    public function __get($offset)
    {
        
    }
    
    /**
     * 
     * 
     * @param   string  $method
     * @param   array   $arguments
     * @return  mixed
     */
    public function __call($method, $arguments)
    {
        
    }
    
    /**
     * 
     * 
     * @return void
     */
    private function factoryBackend($target)
    {
        if (in_array($this->supportedBackends)) {
                        
        }
    }
    
    public function __toString()
    {
        return __CLASS__ . " (Adds support for communicating with databases)";
    }
    
}

?>
