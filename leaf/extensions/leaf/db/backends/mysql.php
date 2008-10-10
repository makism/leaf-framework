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
 * @subpackage	leaf.db.backends
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		$Id$
 */
class Db_Backend_mysql extends Db_Frontend {

	/**
	 *
	 * @param	array	$profile
	 * @param	boolean	$pupulateMetadata
	 * @return	void
	 */
	public function __construct($profile, $populateMetadata)
	{
		parent::__construct($profile, $populateMetadata);
		$this->connect();
		
		if (!empty($this->profile['db_name'])) {
			$this->selectDb($this->profile['db_name']);
		}
	}
	
	/**
	 *
	 *
	 * @return	string
	 */
	public function __toString()
	{
		$status = ($this->isConnected()==FALSE) ? "not" : NULL;
		return "MySQL Driver, {$status} connected";
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function connect()
	{
		$this->conn = @mysql_connect(
			$this->profile['hostname'] . ":" . $this->profile['port'],
			$this->profile['username'],
			$this->profile['password']
		);
		
		// Let`s hide the password for security issues :P
		$this->profile['password'] = str_repeat(
			"*", strlen($this->profile['password'])
		);
		
		if ($this->conn==NULL) {
			//throw new leaf_Exception("asdf", 13499);
		}
		
		// Set the collation
		$charset = (!empty($this->profile['charset']))
					? $this->profile['charset']
					: "UTF-8";
		
		$this->execute("SET NAMES '{$charset}'");
		$this->execute("SET CHARACTER SET {$charset}");
	}
	
	/**
	 *
	 
	 *
	 * @return	boolean
	 */
	public function isConnected()
	{
		if ($this->conn!=NULL)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 *
	 *
	 * @return	boolean
	 */
	public function close()
	{
		@mysql_close($this->conn);
		self::$dbHandler->removeFromPool($this);
	}
	
	/**
	 *
	 *
	 * @param	string	$dbName
	 * @return	boolean
	 */
	public function selectDb($dbName)
	{
		if (mysql_select_db($dbName, $this->conn)) {
			$this->dbName	= $dbName;
			
			if ($this->populateMetadata)
				$this->populateMetadata();
			
			return TRUE;
		} else {
			
			return FALSE;
		}
	}
	
	/**
	 *
	 *
	 * @param	string	$dbName
	 * @param	boolean	$autoSelect
	 * @return	mixed
	 */
	public function createDb($dbName, $autoSelect=TRUE)
	{
		if ($this->execute("CREATE DATABASE {$dbName}"))
			$this->selectDb($dbName);
	}
	
	/**
	 *
	 *
	 * @param	string	$tbl
	 * @return	boolean
	 */
	public function setDefaultTable($tbl)
	{
		if ($this->populateMetadata==TRUE) {
			if ($this->getMetadata($tbl)!=NULL) {
				$this->tblName = $tbl;
				
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	/**
	 *
	 *
	 * @param	string	$query
	 * @return	mixed
	 */
	public function query($sql)
	{
		$this->totalQueries++;
		$query	= mysql_query($sql, $this->conn);
		$rows	= mysql_num_rows($query);
		$this->affectedRows = $rows;
		
		if ($rows==1) {
			return mysql_fetch_assoc($query);
			
		} else if ($rows>1) {
			$resultArray = array();
			
			while($result=mysql_fetch_assoc($query))
				$resultArray[] = $result;
				
			return $resultArray;
		}
		
		return NULL;
	}
	
	/**
	 *
	 *
	 *
	 * @param	string	$str
	 * @return	string
	 */
	public function escapeString($str)
	{
		return mysql_real_escape_string($str, $this->conn);
	}
	
	/**
	 *
	 *
	 * @param	string	$sql
	 * @return	boolean
	 */
	public function execute($sql)
	{
		$this->totalQueries++;
		return mysql_query($sql, $this->conn);
	}
	
	/**
	 *
	 *
	 * @param	string	$tableName
	 * @param	array	$fields
	 * @param	string	$extraSqlQuery
	 * @param	integer	$offset
	 * @param	integer	$rowCount
	 * @return	NULL|object Db_ResultSet
	 */
	public function select()
	{
		$query	 = NULL;
		
		$tblName = NULL;
		$fields	 = NULL;
		$extraSql= NULL;
		$offset	 = NULL;
		$rowCount= NULL;
		
		$args = func_get_args();
		$total= func_num_args();
		
		if ($total==0 && $this->tblName!=NULL) {
			$query = "SELECT * FROM {$this->tblName}";
		}
		
		if ($total>=1) {
			for ($i=0; $i<$total; $i++) {
				$arg = $args[$i];
				
				// fields
				if (is_array($arg) && $fields===NULL) {
					$fields = $arg;
					continue;
				}
				
				// offset
				if (is_int($arg) && $offset===NULL) {
					$offset = $arg;
					continue;
				}
				
				// rowCount
				if (is_int($arg) && $offset!==NULL && $rowCount===NULL) {
					$rowCount = $arg;
					continue;
				}
				
				// tableName
				if (is_string($arg) && $this->getMetadata($arg)!=NULL) {
					$tblName = $arg;
					continue;
				}
				
				// extraSql
				if (is_string($arg) && $extraSql==NULL) {
					$extraSql = $arg;
					continue;
				}
			}
		}
		
		
		if ($fields!=NULL) {
			$fields = implode("," , $fields);
		} else {
			$fields = "*";
		}
		
		$limit = "";
		if ($offset!==NULL || $rowCount!==NULL) {
			$limit = "LIMIT {$offset}";
			
			if ($rowCount!==NULL) {
				$limit .= ", {$rowCount}";
			}
		}
		
		if ($tblName===NULL)
			$tblName = $this->tblName;
		
		$this->totalQueries++;
		$sqlQuery= trim("SELECT {$fields} FROM {$tblName} {$extraSql} {$limit}");
		$query	 = mysql_query($sqlQuery, $this->conn);
		$numRows = mysql_num_rows($query);
		
		if ($numRows==0) {
			return NULL;
			
		} else {
			
			// Pre-emptive object result creation.
			if (self::$defaultOptions['result_creation']==DB_RESULT_CREATION_PREEMPTIVE) {
				$arrayResults = array();
				while($result = mysql_fetch_assoc($query)) {
					$arrayResults[] = new Db_Result($this, $tblName, $result);
				}
				
				$resultSet = new Db_ResultSet($this, $sqlQuery, $arrayResults);
				
				return $resultSet;
				
			// On-demand object result creation.
			} else if (self::$defaultOptions['result_creation']==DB_RESULT_CREATION_ON_DEMAND) {
			
			}
		}
		
	}
	
	/**
	 *
	 *
	 * @param	string	$tableName
	 * @param	array	$fields
	 * @param	string	$extraSqlQuery
	 * @param	integer	$offset
	 * @return	NULL|object Db_Result
	 */
	public function selectRow()
	{
		$args = func_get_args();
		$total= sizeof($args);
		
		$tmp = NULL;
		
		if ($total>=2) {
			for($i=0; $i<$total; $i++) {
				$arg = $args[$i];
				
				if (is_int($arg) && $tmp===NULL) {
					$tmp = $arg;
					continue;
				} else if (is_int($arg) && $tmp!==NULL) {
					unset($args[$i]);
				}
			}
		}
		
		$resultSet = call_user_func_array(array($this, "select"), $args);
		return $resultSet->first();
	}
	
	public function insert()
	{
        $args = func_get_args();
        $total= func_num_args();
        
        if ($total==0) {
            return new Db_ActiveRecord($this);
        }
	}
	
	public function deleteRow()
	{
		if ($this->populateMetadata==FALSE)
			return NULL;
		
		$args = func_get_args();
		$total= func_num_args();
		
		$tblName = NULL;
		$where	 = "WHERE ";
		
		$keys	 = $this->metadata->getTable($this->tblName)->getPrimaryKeys();
		
		for($i=0; $i<$total; $i++) {
			$arg = $args[$i];
			
			if (is_string($arg) && $tblName==NULL && $this->getMetadata($arg)!=NULL) {
				$tblName = $arg;
				continue;
			}
			
			if (($k = current($keys))!==FALSE)
				$where .= "{$k}=\"{$arg}\"";
			
			if (next($keys)!==FALSE)
				if ($i<$total-1)
					$where .= " AND ";
		}
		
		if ($tblName==NULL)
			$tblName = $this->tblName;
		
		$sqlQuery = "DELETE FROM {$tblName} {$where}";
		
		return $this->execute($sqlQuery);
	}
	
	public function deleteByKey()
	{
	
	}
	
	/**
	 *
	 *
	 * @return	integer
	 */
	public function affected()
	{
		return $this->affectedRows;
	}
	
	/**
	 *
	 *
	 *
	 * @param	string	$tblName
	 * @return	integer
	 */
	public function countAll($tblName=NULL)
	{
		$target = ($tblName==NULL)
					? $this->tblName
					: $tblName;
		
		$this->totalQueries++;
		$query = $this->query("SELECT COUNT(*) AS total FROM {$target}");
		
		return $query['total'];
	}
	
	/**
	 *
	 *
	 * @param	boolean	$autoCommit
	 * @return	boolean
	 */
	public function begin($autoCommit=FALSE)
	{
		if ($autoCommit==FALSE)
			$this->execute("SET AUTOCOMMIT=0");
		else
			$this->execute("SET AUTOCOMMIT=1");
	}
	
	/**
	 *
	 *
	 *
	 * @return	boolean
	 */
	public function commit()
	{
	
	}
	
	/**
	 *
	 *
	 *
	 * @return	boolean
	 */
	public function rollback()
	{
	
	}
	
	/**
	 * 
	 * 
	 * @return	integer
	 */
	public function lastInsertId()
	{
	    $query = $this->query("SELECT LAST_INSERT_ID() AS last");
	    return $query['last'];
	}
	
	/**
	 *
	 *
	 * @return	void
	 */
	protected function populateMetadata()
	{
		$tblsMeta= NULL;
		$keys	 = NULL;
		
		$this->totalQueries++;
		$query_tables	= mysql_query("SHOW TABLES FROM {$this->dbName}", $this->conn);
		while ($res_tbls=mysql_fetch_row($query_tables)) {
			$tableName = $res_tbls[0];
			$fields = NULL;
			
			/*$query_keys = mysql_query("SHOW KEYS FROM {$tableName}", $this->conn);
			while ($res_keys = mysql_fetch_assoc($query_keys)) {
				continue;
			}*/
			
			$this->totalQueries++;
			$query_fields = mysql_query("SHOW COLUMNS FROM {$tableName}", $this->conn);
			while ($res_fields = mysql_fetch_assoc($query_fields)) {
				//
				// Field name
				//
				$data['name'] = $res_fields['Field'];
				
				//
				// Field type
				//
				if ( ($pare_idx=strpos($res_fields['Type'], "("))>0 ) {
					$data['type'] = substr(
						$res_fields['Type'],
						0,
						$pare_idx
					);
				} else {
					$data['type'] = $res_fields['Type'];
				}
				
				//
				// Size
				//
				if ($pare_idx>0) {
					$next_pare_idx = strpos(
						substr($res_fields['Type'], $pare_idx),
						")"
					);
					
					$size =substr(
						$res_fields['Type'],
						$pare_idx+1,
						$next_pare_idx-1
					);
					
					$data['size'] = (ctype_digit($size)) ? (int)$size : NULL;
				} else {
					$data['size'] = NULL;
				}
				
				//
				// Value range
				//
				if ($data['size']==NULL && isset($size))
				    $data['valueRange'] = explode(",", str_replace("'", "", $size));
                else
                    $data['valueRange'] = NULL;
				unset($size);

				//
				// Allows NULL value?
				//
				$data['allowsNull'] = ($res_fields['Null']=="YES") ? TRUE : FALSE;
				
				//
				// Is it a key?
				//
				$data['key'] = ($res_fields['Key']=="MUL") ? TRUE : FALSE;
				
				//
				// Is it a primary key?
				//
				$data['primary'] = ($res_fields['Key']=="PRI") ? TRUE : FALSE;
				
				//
				// Is it a unique key?
				//
				$data['unique'] = ($res_fields['Key']=="UNI") ? TRUE : FALSE;
				
				//
				// It`s default value
				//
				$data['defaultValue'] = $res_fields['Default'];
				
				//
				// Is auto_increment...
				//
				$data['autoIncrement'] = (strstr($res_fields['Extra'], "auto_increment"))
										 ? TRUE : FALSE;
				
				
				$fields[$data['name']] = new Db_Metadata_Field($data);
			}
			
			$tblsMeta[$tableName] = new Db_Metadata_Table($tableName, $fields);
		}
		
		$this->metadata = new Db_Metadata_Database($this->dbName, $tblsMeta);
	}

}
