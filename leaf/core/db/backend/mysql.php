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
     * 
     * 
     */
    public function getLink()
    {
        return $this->link;
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
            return (boolean)mysql_close($this->link);
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
        return (boolean)mysql_select_db($dbName, $this->link);
    }
    
    /**
     *
     *  
     * @param   string  $selectQuery
     * @return  object leaf_Db_ResultSet
     * @todo
     * <ol>
     *  <li>Store all Result Sets into an internal array.</li>
     *  <li>Add support for "freeing" the Result Sets via a helper method
     *  (this denotes changes in the leaf_Db_ResultSet).
     * </li>
     * </ol>
     */
    public function fetch($selectQuery)
    {        
        $query = mysql_query($selectQuery, $this->link);
        $result= array();
        
        // If a problem occured with the query, return to the user
        // an empty result set.
        if ($query==false)
            return new leaf_Db_ResultSet($selectQuery, $result);        
        
        // Fetch all the rows.
        if (@mysql_numrows($query)>0)
            while ( $result[] = ($row = mysql_fetch_assoc($query)) );
        
        // Create the result set.
        $resultSet = new leaf_Db_ResultSet($selectQuery, $result);
        
        // Fetch result set`s hash id.
        #$hash = $resultSet->getResultSetId();
        
        // Store the result set, using it`s hash.
        #$this->activeResultSets[$hash] = $resultSet;
        
        return $resultSet;
    }
    
    /**
     * 
     * 
     * @param   string  $tblName
     * @param   string  $order
     * @param   string  $limit
     * @return  object leaf_Db_ResultSet
     */
    public function fetchAll($tblName, $order, $limit)
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
     * Returns the connection`s status.
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
