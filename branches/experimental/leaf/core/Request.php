<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Provides access to all elements that compose the Uri, and generally the
 * current request.
 *
 * @package     leaf
 * @subpackage  core
 * @author	    Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 * @todo
 * <ol>
 *  <li>Add support for Sessions.</li>
 *  <li>Add support for Cookies.</li>
 *  <li>Update documentation/comments.</li>
 * </ol>
 */
final class leaf_Request extends leaf_Common {

    /**
     * The headers that Apache sent.
     *
     * @var array
     */
    private static $headers = NULL;

    /**
     * The extra segments found in the Uri. 
     *
     * @var array
     */
    private static $segments = NULL;
    
    /**
     * The POST parameters.
     * 
     * @var array
     */
    private $parameters = NULL;

    /**
     * The current query string that found in the Uri.
     *
     *
     * @var string
     */
    private static $immutableQueryString = NULL;

    /**
     * Will hold the new query string that we will build.
     *
     *
     * @var string
     */
    private static $mutableQueryString = NULL;
    
    /**
     * The query string found in the Uri.
     *
     * For more info take a look at the class leaf_Router.
     *
     * @var array
     */
    private static $queryElems = NULL;

    /**
     * Will hold the elements that will make up the new mutable query string.
     *
     * @var array
     */
    private static $mutableQueryElems = NULL;

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
     * Internally uses the class {@link leaf_Router} in order to export
     * information like, the Controller name, the Controller`s name as 
     * is <i>must</i> be, the Action, etc.
     *
     * @return  void
     */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);

        $this->controller       = $controllerName;
        $this->controllerFile   = $controllerName . "_Controller.php";
        $this->action           = $this->Dispatcher->dispatchObject->action;
        
        // 
        self::$segments = $this->Router->segments();
        
        // Fetch the Query String from the {@link leaf_Router router} object.
        self::$queryElems = $this->Router->queryStringElements();

        // Assign the Query String
        self::$immutableQueryString = $this->Router->queryString();
        
        // 
        if (!empty($_POST)) {
            $this->parameters = $_POST;
            //unset($_POST);
        }

        // Gather the request headers.
        if (function_exists('apache_request_headers'))
            self::$headers = apache_request_headers();
	}
	
	/**
	 * Returns the requested class name (Controller), suffixed with
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
    	return $this->controller;
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
	
    
    /**************************************************************************
     * Segments                                                               *
     **************************************************************************

    /**
     * Retrieves the requested (numeric) offset from the segments.
     *
     * @param   integer $n
     * @return  string|NULL
     */
	public function getSegment($n)
	{
	    if (!empty(self::$segments))
	       if (array_key_exists($n-1, self::$segments))
    	       return self::$segments[$n-1];
	   
        return NULL;
	}
    
    /**
     * Returns the total number of segments.
     *
     * @return  integer
     */
	public function getSegmentsSize()
	{
	    return $this->Router->segmentsSize();
	}
	
	/**
	 * Returns all the extra segments, separated with slashes.
	 *
	 * @return	string
	 */
	public function getRawSegments()
	{
		$returnStr = NULL;
		$total = $this->getSegmentsSize();
		
		if ($total==0)
			return NULL;
		
		for ($i=0; $i<$total; $i++)
			$returnStr .= self::$segments[$i] . "/";
		
		return $returnStr;
	}

    /**
     * Returns the segments` array.
     *
     * @return  array
     */
    public function getSegmentsAsArray()
    {
        return self::$segments;
    }
    

    /**************************************************************************
     * Get                                                                    *
     **************************************************************************
    
    /**
     * Returns the complete query string.
     * 
     * @return  string|NULL
     */
    public function getRawQueryString()
    {
    	return self::$immutableQueryString;
    }
    
    /**
     *
     * 
     * @return  string|NULL
     */
    public function getPreparedQueryString()
    {
        return self::$mutableQueryString;
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function prepareQueryString(array $set)
    {
        self::$mutableQueryElems = array_unique(
            array_merge (
                $set,
                (array)self::$mutableQueryElems
            )
        );
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
    public function getQueryString($offset)
    {
        if (!empty(self::$queryElems))
            if (array_key_exists($offset, self::$queryElems))
                return self::$queryElems[$offset];

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
        if (self::$queryElems!=NULL)
            if (array_key_exists($key, self::$queryElems))
                return TRUE;
		
		return FALSE;
    }
	
	/**
	 * Recreates the query string based on the elements' array.
	 *
	 * @return	void
	 */
	private function updateQueryString()
	{
        self::$mutableQueryString = "?";
		
		$total = sizeof(self::$mutableQueryElems);
		
		for ($i=0; $i<$total; $i++) {
			list($Key, $Value) = each(self::$mutableQueryElems);
			
            self::$mutableQueryString .= $Key;
			
			if ($Value!=NULL)
				self::$mutableQueryString .= "=" . $Value;
			
			if ($i<$total-1)
				self::$mutableQueryString .= "&";
		}
		
		reset(self::$mutableQueryElems);
	}
	
	/**
	 * Merges the immutableQueryString with the mutableQueryString.
	 * The result will be stored in the mutableQueryString.
	 *
	 * @return	void
	 */
	public function mergeQueryStrings($replace=TRUE)
	{
	    if ($replace==FALSE) {
	        
	    } else
	        self::$mutableQueryElems = array_unique(
	           array_merge(
	               (array)self::$mutableQueryElems,
	               (array)self::$queryElems
	           )
	        );
	}
	
	/**
	 * Append's a key with an optional value at the query string.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @param  boolean $replace
	 * @return void
	 */
	public function appendQueryString($key, $value=NULL, $replace=TRUE)
	{
		$value = (isset($value)) ? $value : NULL;
		
		if ($replace==FALSE)
		  if (array_key_exists($key, self::$mutableQueryElems))
		      return;

        self::$mutableQueryElems[$key] = $value;
		  
		$this->updateQueryString();
	}
	
	/**
	 * Removes a key/value from the query string.
	 * 
	 * @return void
	 */
	public function removeQueryString($key)
	{
	    if (array_key_exists($key, $this->mutableQueryElems))
	       unset(self::$mutableQueryElems[$key]);
	    
	    $this->updateQueryString();
	}
	
	
    /**************************************************************************
     * Post                                                                   *
     **************************************************************************/

    /**
     * 
     * 
     * @return  array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * 
     * 
     * @return  string|NULL
     */
    public function getParameter($str)
    {
        if (array_key_exists($str, $this->parameters))
            return $this->parameters[$str];

        return NULL;
    }
    
    /**
     * 
     * 
     * @return  array
     */
    public function getParameterNames()
    {
        return array_keys($this->parameters);
    }
    
    /**
     * 
     * 
     * @return  array
     */
    public function getParameterValues()
    {
        return array_values($this->parameters);   
    }
    
    /**
     * 
     * 
     * @return  integer
     */
    public function getTotalParameters()
    {
        return sizeof($this->parameters);
    }
    
    /**
     * 
     * 
     * @return  boolean|NULL
     */
    public function hasPosted()
    {
        if ($this->getHeaders()!=NULL) {
            $contentType = $this->getHeader("Content-Type");
            
            if ($contentType==NULL || strpos($contentType, "form")===FALSE)
                return FALSE;
            else
                return TRUE;
        }
        
        return NULL;
    }
    
    
    /**************************************************************************
     * Headers                                                                *
     **************************************************************************

    /**
     * Returns all the headers.
     *
     * @return  array|NULL
     */
    public function getHeaders()
    {
        return self::$headers;
    }

    /**
     * Returns the headers` names.
     *
     * @return array|NULL
     */
    public function getHeaderNames()
    {
        if (!empty(self::$headers))
            return array_keys(self::$headers);
        else
            return NULL;
    }

    /**
     * Checks if the requested header exists.
     *
     * @param   string  $header
     * @return  boolean
     */
    private function getHeaderExists($header)
    {
        if (!empty(self::$headers))
            return array_key_exists($header, self::$headers);
        else
            return NULL;
    }

    /**
     * Returns the body of a header.
     *
     * @param   string  $header
     * @return  string|NULL
     */
    public function getHeader($header)
    {
        if ($this->getHeaderExists($header))
            return self::$headers[$header];
        else
            return NULL;
    }

}

