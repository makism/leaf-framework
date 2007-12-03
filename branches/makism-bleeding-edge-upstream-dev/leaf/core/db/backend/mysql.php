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
 * @subpackage  core.db.backend
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 * </ol>
 */
final class leaf_Db_Backend_mysql extends leaf_Db_Backend {
   

    /**
     *
     * 
     * @param   array   $profile
     * @return  void
     */
    public function __construct(array $profile)
    {
        parent::__construct();
        
        $this->dbProfile = $profile;
    }
    
    /**
     * 
     * 
     * @return  boolean
     */
    public function connect()
    {
        $host = $this->dbProfile['hostname'];
        $port = ($this->dbProfile['port']=="")
                ? 3306
                : $this->dbProfile['port'];
        $user = $this->dbProfile['username'];
        $pass = $this->dbProfile['password'];
        $db   = $this->dbProfile['db_name'];
        
        $server = $host . ":" . $port;

        $this->link = mysql_connect($server, $user, $pass);
        
        if ($db!="") {
            $this->selectDb($db);
        }
        
        if ($this->link!=NULL)
            return true;
        else
            return false;
    }
    
    /**
     * 
     *
     * @return  boolean
     */
    public function disconnect()
    {
        return;
    }
    
    /**
     * 
     *
     * @param   string  $dbName
     * @return  boolean
     */
    public function selectDb($dbName)
    {
        return mysql_select_db($dbName, $this->link);
    }
    
    /**
     * 
     * 
     * @return  integer
     */
    public function connectionStatus()
    {
        
    }
    
    /**
     * 
     * 
     */
    public function select($selectQuery)
    {

    }
    
    /**
     * 
     */
    public function insert($insertQuery)
    {
        
    }
    
    /**
     * 
     */
    public function query($rawQuery)
    {
        
    }

}

?>