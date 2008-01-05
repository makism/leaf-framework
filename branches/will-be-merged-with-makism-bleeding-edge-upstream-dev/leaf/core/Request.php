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
 * Provides access to all elements that compose the Uri.
 *
 * This means, that we have request and refer to the file that
 * the requested Controller is located in, the Action, the extra
 * segments and finally the query string.<br>
 * Also, this class implements some basic methods related with the
 * Uri handling, like redirecting and Uri-reconstruction.
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @see         leaf_Router
 * @version     SVN: $Id$
 */
final class leaf_Request {

	/**
	 * The current query string that found in the Uri.
	 *
	 * It is immutable, that means that it can not be modified.
	 *
	 * @var	string
	 */
	private $immutablequeryString = NULL;
	
	/**
	 * Will hold the new query string that we will build.
	 *
	 * This string mutable.
	 *
	 * @var	string
	 */
	private $mutableQueryString = NULL;

    /**
     * The extra segments found in the Uri.
     *
     * For more info take a look at the class leaf_Router.
     *
     * @var array
     */
    private $segments = NULL;

    /**
     * The requested class name (Controller), suffixed with "_Controller".
     *
     * @var string
     */
    private $controller = NULL;

    /**
     * The file name in which the requested Controller is located.
     *
     * The complete file name will look something like this:<br>
     * <pre>/var/www/http/applications/Blog/Blog_Controller.php</pre>
     *
     * @var string
     */
    private $controllerFile = NULL;
    
    /**
     * The requested method name (Action).
     *
     * @var string
     */
    private $action = NULL;

    /**
     * The query string found in the Uri.
     *
     * For more info take a look at the class leaf_Router.
     *
     * @var array
     */
    private $queryElems = NULL;
	
	/**
	 * Will hold the elements that will make up the new mutable query string.
	 *
	 * @var	array
	 */
	private $mutableQueryElems = NULL;


    /**
     * Internally uses the class {@link leaf_Router} in order to export
     * information like, the Controller name, the Controller`s name as 
     * is <i>must</i> be, the Action, etc.
     *
     * @return  void
     */
	public function __construct()
	{
        
	}
	
	/**
	 * Returnst the requested class name (Controller), suffixed with
     * "_Controller".
     *
	 * @return	string
	 */
    public function getControllerName()
    {
        return $this->controller;
    }

	/**
	 * Returns the file name that contains the current Controller.
     *
	 * @return	string
	 */
    public function getControllerFileName()
    {
        return $this->controllerFile;
    }

    /**
     * Returns the current Application`s name.
     *
     * @return  string
     */
    public function getApplicationName()
    {
    	return $this->Router->getClassName();
    }
    
    /**
     * Returns the current Action's name.
     *
     * @var string 
     */
    public function getActionName()
    {
    	return $this->action;
    }
	
    /**
     * Returns the total number of segments.
     *
     * @return  integer
     */
	public function totalSegments()
	{
	    return sizeof($this->segments);
	}
	
    /**
     * Retrieves the requested (numeric) offset from the segments.
     *
     * @param   integer $n
     * @return  string|NULL
     */
	public function segment($n)
	{
	    if (array_key_exists($n-1, $this->segments))
	       return $this->segments[$n-1];
	    else
	       return NULL;
	}

    /**
     * Returns the segments` array.
     *
     * @return  array
     */
    public function segmentsAsArray()
    {
        return $this->segments;
    }
	
	/**
	 * Returns all the extra segments, separated with slashes.
	 *
	 * @return	string
	 */
	public function getSegments()
	{
		$returnStr = NULL;
		$total = $this->totalSegments();
		
		if ($total==0)
			return NULL;
		
		for ($i=0; $i<$total; $i++)
			$returnStr .= $this->segments[$i] . "/";
		
		return $returnStr;
	}

    /**
     * Returns the complete query string.
     * 
     * @var array
     */
    public function getQueryString()
    {
    	return $this->mutableQueryString;
    }
    
    /**
     * Retrieves the value for the requested key.
     *
     * @param   string  $offset
     * @return  mixed
	 * @todo
	 * <ol>
	 *  <li>Possible method refactor.</li>
	 * </ol>
     */
    public function queryStringValue($offset)
    {
        if ($this->queryElems!=NULL)
            if (array_key_exists($offset, $this->queryElems))
                return $this->queryElems[$offset];
            else
                return NULL;
    }

    /**
     * Checks if the specific key exists in the Query String.
     *
     * @param   string  $key
     * @return  boolean
     */
    public function queryStringKeyExists($key)
    {
        if ($this->queryElems!=NULL)
            if (array_key_exists($key, $this->queryElems))
                return true;
		
		return false;
    }
	
	/**
	 * Recreates the query string based on the elements' array.
	 *
	 * @return	void
	 */
	private function updateQueryString()
	{
		$this->mutableQueryString = "?";
		
		$total = sizeof($this->mutableQueryElems);
		
		for ($i=0; $i<$total; $i++) {
			list($Key, $Value) = each($this->mutableQueryElems);
			
			$this->mutableQueryString .= $Key;
			
			if ($Value!=NULL)
				$this->mutableQueryString .= "=" . $Value;
			
			if ($i<$total-1)
				$this->mutableQueryString .= "&";
		}
		
		reset($this->mutableQueryElems);
	}
	
	/**
	 * Merges the immutableQueryString with the mutableQueryString.
	 * The result will be stored in the mutableQueryString.
	 *
	 * @return	void
	 * @todo
	 * <ol>
	 *  <li>Implement.</li>
	 * </ol>
	 */
	public function mergeQueryStrings()
	{
	
	}
	
	/**
	 * Append's a key with an optional value at the query string.
	 *
	 * @param	string	$key
	 * @param	string	$value
	 * @return	void
	 */
	public function appendQueryString($key, $value=NULL)
	{
		$value = (isset($value)) ? $value : NULL;
		$this->mutableQueryElems[$key] = $value;
		
		$this->updateQueryString();
	}
	
    /**
     * Return the current query string, as a string.
     *
     * @return  string
	 * @todo
	 * <ol>
	 *  <li>Possible complete method refactor.</li>
	 * </ol>
     */
    public function getFormattedQueryString()
    {
        if ($this->queryElems!=NULL) {
            $str = NULL;
			
            foreach($this->queryElems as $Var => $Val) {
                if ($Val=="" || empty($Val))
                    $Val = "NULL";
                    
                $str .= $Var . " = " . $Val . ", ";
            }
            
            if (preg_match("@, $@", $str)) {
                $str = preg_replace("@, $@", "", $str);
            } 
			
            return $str;
        } else 
            return NULL;
    }

}
