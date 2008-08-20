<?php

/** 
 *
 *
 *
 * @author	Avraam Marimpis <makism@users.sourceforge.net>
 * @since	1.0
 * @version	$Id$
 */
class Scaffolding_Controller extends leaf_Controller {

	const ALLOW_CALL = FALSE;
	
	const ALLOW_HOOKS = FALSE;
	
	const IS_ENABLED = TRUE;
	
	
	const LOGIN_USERNAME = "98798241748efaccb230386437b7873a478f5bd4";
	
	const LOGIN_PASSWORD = "98798241748efaccb230386437b7873a478f5bd4";
	
	private $isLoggedIn = FALSE;
	
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $currProfile = NULL;
	
	/**
	 *
	 *
	 * @var	string
	 */
	private $currTable = NULL;
	
	/**
	 *
	 *
	 * @var	array
	 */
	private $data = NULL;
	
	
	/**
	 *
	 *
	 *
	 * @return	void
	 */
	public function init()
	{
		$this->handleLogin();
		
		$this->Loader->extension("leaf.db.Db");
		$this->Local->model("Scaffold");
		
		$this->data['currProfile']	= NULL;
		$this->data['currTable']	= NULL;
		$this->data['profiles']		= $this->Scaffold->getProfiles();
		
    	if ($this->Request->getSegment(1)!=NULL &&
            $this->Request->getSegment(2)!=NULL)
        {
            $this->currProfile	= $this->Request->getSegment(1);
            $this->currTable	= $this->Request->getSegment(2);
            
            if (array_key_exists($this->currProfile, $this->data['profiles'])) {
            	if (array_key_exists($this->currTable,
            						 $this->data['profiles'][$this->currProfile]['tables'])
            	)
            	{
                    $this->Db->connect($this->currProfile);
                	$this->Db->{$this->currProfile}->setDefaultTable($this->currTable);
            	}
            }
        }
	}
	
	/**
	 *
	 *
	 *
	 */
	private function handleLogin()
	{
		if (
			!isset($_SERVER['PHP_AUTH_USER']) ||
			(isset($_SERVER['PHP_AUTH_USER']) && sha1($_SERVER['PHP_AUTH_USER'])!=self::LOGIN_USERNAME) ||
			(isset($_SERVER['PHP_AUTH_PW']) && sha1($_SERVER['PHP_AUTH_PW'])!=self::LOGIN_PASSWORD)
		)
		{
		    header('WWW-Authenticate: Basic realm="Scaffolding App"');
		    header('HTTP/1.0 401 Unauthorized');
		    echo 'Ακυρώθηκε η αυθεντικοποίηση.';
		    exit;
		}
	}
	
	/**
	 *
	 *
	 * @return	void
	 */
	public function handlePost()
	{
		$action = $this->Dispatcher->getCurrentAction();
		
		switch($action) {
			case "index":
				list($this->currProfile, $this->currTable) = explode(".", $_POST['profile']);
				$this->data['currProfile']	= $this->currProfile;
				$this->data['currTable']	= $this->currTable;
				
				$this->Request->setSegment($this->currProfile);
				$this->Request->setSegment($this->currTable);
			break;
			case "insert":
			     $ins = $this->Db->{$this->currProfile}->insert();
			     foreach ($_POST as $Field => $Value) {
			         $ins->__set($Field, $Value);
			     }
			     
			     $ins->save();
			break;
		}
	}
	
	/**
	 *
	 *
	 * @return	void
	 */
	public function destroy()
	{
	    
	}
	
	/**
	 *
	 *
	 *
	 * @return	void
	 */
	public function index()
	{
		if (!empty($this->currProfile)) {
			$conn = $this->Db->connect($this->currProfile);
			$conn->setDefaultTable($this->currTable);
			
			$this->data['metadata'] = $conn->getMetadata($this->currTable);
			$this->data['primaryKeys']= $this->data['metadata']->getPrimaryKeys();
			$this->data['total']	= $conn->countAll();
			$this->data['records']	= $conn->select(10);
		}
		
		$this->Request->setSegments(array(
			 $this->currProfile,
			 $this->currTable
			)
		);
		
		$this->View->render("header", $this->data, VIEW_MERGE);
        $this->View->view("footer.html");
	}
	
	/**
	 *
	 *
	 * @return	void
	 */
	public function delete()
	{
        if (($this->Db->{$this->currProfile}!=NULL) && isset($_GET['id'])) {	
            $res = $this->Db->{$this->currProfile}->deleteRow($_GET['id']);
            
            echo $res;
        }
	}
	
	public function truncate()
	{
        if ($this->Db->{$this->currProfile}!=NULL) {	
    		$this->Db->{$this->currProfile}->truncate();
            $this->Response->forward("index");
        }
	}
	
	/**
	 *
	 *
	 *
	 *
	 */
	public function update()
	{
        if ($this->Db->{$this->currProfile}!=NULL) {	
    		$conn = $this->Db->{$this->currProfile};
    
    		$keys = unserialize(base64_decode($_POST['k']));
    		$field= $_POST['f'];
    		$value= $_POST['v'];
    		
    		// contruct a "WHERE..." clause
    		$where = " WHERE " ;
    		for($i=0; $i<sizeof($keys); $i++) {
    			list($k, $v) = each ($keys);
    			
    			$where .= "{$k}=\"{$v}\" ";
    			
    			if ($i<sizeof($keys)-1)
    				$where.= " AND ";
    		}
    		
    		$f = $conn->selectRow($where);
    		$f->__set($field, $value);
    		// or: $f->{$field} = $value;
    		$res = $f->update();
    		
    		echo $res;
        }
	}
	
	public function insert()
	{
        $this->Response->forward("index");
	}

}