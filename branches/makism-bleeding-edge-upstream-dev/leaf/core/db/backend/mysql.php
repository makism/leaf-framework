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
 * MySQL database driver.
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
     * Creates a link to the database server using
     * the profile options.
     * 
     * @return boolean
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
     * Closes the link.
     *
     * @return  boolean
     */
    public function disconnect()
    {
        if ($this->isConnected())
            return mysql_close($this->link);
        else
            return true;
    }
    
    /**
     * Selects a database.
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
     * Executes a generic sql query.
     *
     * @param   string  $rawQuery
     * @return  mixed
     */
    public function query($rawQuery)
    {

    }
    
    /**
     * 
     */
    public function freeResultSet($resultSet)
    {
        
    }
    
    /**
     * 
     * @return boolean
     */
    public function isConnected()
    {
        if ($this->link!=NULL)
            return true;
        else
            return false;
    }

}

?>
