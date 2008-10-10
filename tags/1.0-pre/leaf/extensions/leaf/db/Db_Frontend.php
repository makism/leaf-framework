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
 * @package		extensions
 * @subpackage	leaf.db
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
abstract class Db_Frontend {

	/**
	 *
	 *
	 * @var	boolean
	 */
	protected $populateMetadata = FALSE;

	/**
	 *
	 *
	 * @var	object Db_Metadata_Database
	 */
	protected $metadata = NULL;
	
	/**
	 *
	 *
	 * @var	array
	 */
	protected $profile = array();
	
	/**
	 * Connection resource.
	 *
	 * @var	resource
	 */
	protected $conn = NULL;
	
	/**
	 * Selected database.
	 *
	 * @var	string
	 */
	protected $dbName = NULL;
	
	/**
	 * Current working table.
	 *
	 * @var	string
	 */
	protected $tblName = NULL;
	
	/**
	 * The number of rows, that the last query affected.
	 *
	 * It is used only for the methods "query()" and
	 * "execute()".
	 *
	 * @var	integer
	 */
	protected $affectedRows = NULL;
    
	/**
	 * The total number of queries that this instance has made.
	 *
	 * @var	integer
	 */
	protected $totalQueries = 0;
	
	/**
	 *
	 *
	 * @var	array
	 */
	protected static $defaultOptions = NULL;
	
	/** 
	 * 
	 *
	 * @var	object Db
	 */
	protected static $dbHandler= NULL;

	
	/** 
	 *
	 *
	 * @param	array	$profile
	 * @return	void
	 */
	public function __construct($profile, $populateMetadata=TRUE)
	{
		$this->profile = $profile;
		$this->populateMetadata = $populateMetadata;
		
		if (self::$dbHandler==NULL)
			self::$dbHandler = leaf_Base::fetch('Loader')->Db;
		
		if (self::$defaultOptions==NULL)
			self::$defaultOptions = self::$dbHandler->getConfig();
	}
	

/*****************************************************************************
*************************************************** CONNECTION-RELATED METHODS
******************************************************************************/
	
	/**
	 * Connects to the database using the profile data.
	 *
	 * @return	boolean
	 */
	abstract public function connect();
	
	/**
	 * Checks if the connection is alive.
	 *
	 * @return	boolean
	 */
	abstract public function isConnected();
	
	/**
	 * Closes connection.
	 *
	 * @return	boolean
	 */
	abstract public function close();
	
	
/*****************************************************************************
************************************************************** GENERAL METHODS
******************************************************************************/
	
	/**
	 * Selects a database to work on.
	 *
	 * @param	string	$dbName
	 * @return	boolean
	 */
	abstract public function selectDb($dbName);
	
	/**
	 * Creates a database.
	 *
	 * @param	string	$dbName
	 * @param	boolean	$autoSelect
	 * @return	mixed
	 */
	abstract public function createDb($dbName, $autoSelect=TRUE);
	
	/**
	 * Sets a currently working table.
	 *
	 * @param	string	$tblName
	 * @return	boolean
	 */
	abstract public function setDefaultTable($tblName);
	
	public function getDefaultTable()
	{
	    return $this->tblName;
	}
	
	public function getDatabaseName()
	{
	    return $this->dbName;
	}
	
/*****************************************************************************
********************************************************* INTERNAL-USE METHODS
******************************************************************************/
	
	/**
	 *
	 *
	 * @return	void
	 */
	abstract protected function populateMetadata();
	
	
/*****************************************************************************
************************************************** RAW QUERY EXECUTION METHODS
******************************************************************************/
	
	/**
	 * Executes SELECT queries.
	 * The value returned, is based on the driver used.
	 *
	 * @param	string	$query
	 * @return	mixed
	 */
	abstract public function query($query);
	
	/**
	 * Executes a query other than SELECT.
	 * The value returned, is based on the driver used.
	 *
	 * @param	string	$query
	 * @return	boolean
	 */
	abstract public function execute($query);
	
	
/*****************************************************************************
********************************************************* COUNT RESULT METHODS
******************************************************************************/
	
	/**
	 * Returns the total number of rows in the currently
	 * working table (or the one specified).
	 *
	 * @param	string	$tblName
	 * @return	integer
	 */
	abstract public function countAll($tblName=NULL);
	
	/**
	 * Counts the rows in the result set produced
	 * by the "execute" method.
	 *
	 * @var	integer
	 */
	abstract public function affected();

	
/*****************************************************************************
*************************************************************** INSERT METHODS
******************************************************************************/
	
	abstract public function insert();
	
/*****************************************************************************
*************************************************************** SELECT METHODS
******************************************************************************/
	
	/**
	 * Select statement.
	 *
	 * @return	mixed
	 */
	abstract public function select();
	
	/**
	 * Selects one row.
	 *
	 * @return	mixed
	 */
	abstract public function selectRow();
	
	
	/**
	 * Selects one row.
	 *
	 * @return	mixed
	 */
	//abstract public function selectWithKeys()
	
	
/*****************************************************************************
*************************************************************** DELETE METHODS
******************************************************************************/
	
	/**
	 *
	 *
	 *
	 */
	abstract public function deleteRow();
	
	
/*****************************************************************************
***************************************************************** TRANSACTIONS
******************************************************************************/

	/**
	 * Begin transcation.
	 *
	 * If $autoCommit, is set to TRUE, there is no need
	 * for you to commit() the changes.
	 * Please consider the manual pages of the driver
	 * you use.
	 *
	 * @boolean	boolean	$autoCommit
	 * @return	boolean
	 */
	abstract public function begin($autoCommit=FALSE);
	
	/**
	 * Commit transaction.
	 *
	 * @return	boolean
	 */
	abstract public function commit();
	
	/**
	 * Rollback transaction.
	 *
	 * @return	boolean
	 */
	abstract public function rollback();

	
/*****************************************************************************
***************************************************************** MISC METHODS
******************************************************************************/
	
	/**
	 * 
	 * 
	 * @return	integer
	 */
	abstract public function lastInsertId();
	
	/**
	 * Enter description here...
	 *
	 * @param	string	$sql
	 * @param	array	$data
	 * @return	mixed
	 */
	public function preparedStatement($sql, array $data)
	{
	    // Helper variables...
        $result   = NULL;
        $total    = NULL;
        $resultSql= NULL;
        
	     // Trim the space.
        $sql = trim ($sql);
        
        // Extract the sql command.
        $cmd = substr(
            $sql,
            0,
            strpos($sql, " ")    
        );
        
        //
        // Execute the regular expressions...
        //        
        if ($cmd=="INSERT") {
            $pattern =
            	"@" .
#                "\(?" .             # possible starting "("
                "\s*?".              # possible whitespace
                "(?P<fields>\?)" .   # the "?" character
                "\s*?".              # possible whitespace
#                ",?" .              # possible trailing ","
                "\s*?".              # possible whitespace
#                "\)?" .             # possbiel ending ")"
                "@ui";
	    } else if ($cmd=="SELECT" || $cmd=="DELETE") {
            $pattern =
                "@" .
                "(?P<fields>[a-z]*?)" .                          # match field name 
            	"\s*?" .                                         # possible whitespace
                "(=|>\s?=|<\s?=|!\s?=|<\s?>|<\s?=\s?>)" .        # operator
                "\s*?" .							             # possible whitespace
                "\?" .                                           # the "?" character 
                "([a-z]*?)?" .                                   # possbile next characters 
            	"@ui";
        }
        
        $result = preg_match_all($pattern, $sql, $matches, PREG_OFFSET_CAPTURE);
        $total  = sizeof($matches[1]);
        $resultSql = $sql;
        
        // So, let`s replace every "?" occurence with the data passed...
        if ($total==sizeof($data)) {
            if ($cmd=="INSERT") {
                for ($i=0; $i<$total; $i++) {
                    $replacement = NULL;
                    
                    if (is_numeric($data[$i])) {
                        $replacement = $data[$i];
                    } else if (is_null($data[$i])) {
                        $replacement = "NULL";
                    } else {
                        $replacement = "'" . $this->escapeString($data[$i]) . "'";
                    }
                    
                    $resultSql = preg_replace(
                        $pattern,
                        $replacement,
                        $resultSql,
                        1
                    );
                    
                }
                
            } else if ($cmd=="SELECT" || $cmd=="DELETE") {
                for ($i=0; $i<$total; $i++) {
                    $replacement = NULL;
                    
                    if (is_numeric($data[$i])) {
                        $replacement = $data[$i];
                    } else if (is_null($data[$i])) {
                        $replacement = "NULL";
                    } else {
                        $replacement =
                            $matches['fields'][$i][0] . " " .
                            $matches[2][$i][0] .
							" '" .
                            $this->escapeString($data[$i]) .
							"'";
                    }
                    
                    $resultSql = preg_replace(
                        "@" . preg_quote($matches[0][$i][0]) . "@ui",
                        $replacement,
                        $resultSql,
                        1
                    );
                }
                
            }
        }
        
        $this->execute($resultSql);

	}

	/**
	 * Truncates a table.
	 *
	 * @param	string	$tblName
	 * @return	mixed
	 */
	public function truncate($tblName=NULL)
	{
		$target = ($tblName!=NULL)
					? $tblName
					: (
						($this->tblName!=NULL)
							? $this->tblName
							: NULL
					);
		
		if ($target!=NULL)
			return $this->execute("TRUNCATE {$target}");
	}
	
	
	/**
	 * Returns the name of the profile that is in use.
	 *
	 * @return	string
	 */
	public function getProfileName()
	{
		return $this->profile['name'];
	}
	
	/**
	 * Returns the tables of the current database.
	 *
	 * @return	array
	 */
	public function getTables()
	{
		if ($this->metadata!=NULL)
			return $this->metadata->getTables();
	}
	
	/**
	 * Returns the metadata for either a specific table or
	 * the whole database.
	 *
	 * @param	string|NULL	$tableName
	 * @return	array
	 */
	public function getMetadata($tableName=NULL)
	{
		if ($this->populateMetadata==TRUE) {
			if ($tableName!=NULL) {
				return $this->metadata->getTable($tableName);
			} else {
				return $this->metadata;
			}
		}
	}

	/**
	 *
	 *
	 * @param	string	$str
	 * @return	string
	 */
	abstract public function escapeString($str);
	
}
