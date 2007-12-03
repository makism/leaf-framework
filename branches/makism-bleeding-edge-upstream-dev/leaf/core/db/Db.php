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
require_once LEAF_BASE . "core/db/Db_Backend.php";

/**
 * 
 */
require_once LEAF_BASE . "core/db/Db_ActiveRecord.php";


/**
 * 
 */
require_once LEAF_BASE . "core/db/backend/mysql.php";

/**
 * 
 */
define('DB_SCOPE_PROFILE', 1);

/**
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
    
    const LEAF_CLASS_ID = "LEAF_DB-1_0_dev";

    
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
     * "mysqli", "sqlite2", "pdo" and "oracle" will follow.
     * 
     * @var array
     */
    private $supportedBackends = array();
    
    /**
     * Holds all the declared profiles in the database
     * configuration file.
     * 
     * @var array
     */
    private $allProfiles = array();
    
    /**
     * All the parameters specified in the database configuration file.
     * 
     * @var array
     */
    private $options = array();
    
    
    /**
     * 
     * 
     * @param   array   $opts
     * @return  void
     * @todo
     * <ol>
     *  <li>Check if the assignment of the db conf option can be ignored.
     *  This will be replaced, with a reference to the actual options using
     *  the Config object via the Registry.</li>
     * </ol>
     */
    public function __construct(array $opts=NULL)
    {
        parent::__construct(self::LEAF_REG_KEY);
        
        // Currently, we support only the classic "mysql" extensions.
        // Let`s find out if they are built-in.
        if (extension_loaded("mysql"))
            $this->supportedBackends[] = "mysql";
        
        // Fetch all the database configuration options. 
        $confOpts = $this->Config->getByHashKey("database"); 
        $this->allProfiles  = $confOpts['profiles'];
        $this->options = $confOpts['general'];
        
        // Support for settings
        if ($opts!=NULL) {

            // Auto-bind the requested db profile
            if (isset($opts['profile'])) {
                $this->bind($opts['profile']);
            }

            // Auto-connect
            if (isset($opts['auto_connect']) &&
                $opts['auto_connect']==TRUE)
            {
                $this->{$opts['profile']}->connect();            
            }
        }
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
     * @todo 
     * <ol>
     *  <li>Implement.</li>
     * </ol>
     */
    public function set($parameter, $value, $scope=0)
    {
        return;
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
        if (array_key_exists($profileName, $this->allProfiles)) {
            
            $curr = $this->allProfiles[$profileName];
            
            if (in_array($curr['backend'], $this->supportedBackends)) {
                $driver = "leaf_Db_Backend_" . $curr['backend'];
                $this->connectionPool[$profileName] = new $driver($curr);
            }
        }
    }
    
    /**
     * Returns the requested object from the {@link leaf_Registry $Registry},
     * <b>or</b> the requested database connection link.
     * 
     * @param  string  $key
     * @return object|NULL
     * @todo
     * <ol>
     *  <li>Support for accessing the Models using a member property named "Models".
     *  <br>For example (<i>in Controller scope</i>):
     *  <code>$this->Models->modelName</code> <b>or</b>
     *  <code>$this->Models['modelName']</code><br>
     *  This denotes changes in the {@link leaf_Loader} class as well.</li>
     * </ol>
     */
    protected function __get($key)
    {
        // Search the requested key in the Registry and
        // return it if found.
        if (leaf_Registry::getInstance()->isRegistered($key)!=FALSE)
            return parent::__get($key);
            
        // Otherwise, asume that a database connection link is
        // requested and thus return it -if found-.
        else
            return $this->connectionPool[$key];
    }
    
    public function __toString()
    {
        return __CLASS__ . " (Adds support for communicating with databases)";
    }
    
}

?>
