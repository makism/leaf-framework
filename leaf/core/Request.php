<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf\Core;


/**
 * Provides access to all elements that compose the Uri, and generally the
 * current request.
 *
 * @package     leaf
 * @subpackage  core
 * @author	    Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
final class Request extends Common {

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
	 * The query string`s as an associative array.
	 *
	 * @var	array
	 */
	private static $queryString = NULL;

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
     * Internally uses the class {@link leaf_Router} and {@link leaf_Dispatcher}
     * in order to export information like, the Controller name,
     * the Controller`s name, the Action, etc.
     *
     * @return  void
     */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);

        $this->controller       = $controllerName;
        $this->controllerFile   = $controllerName . "_Controller.php";
        $this->action           = $this->Dispatcher->getCurrentAction();
        
        // Fetch the segments for the Router.
        self::$segments = $this->Router->segments();
		
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
     * Returns the current (running) Application`s name.
     *
     * @return  string
     */
    public function getApplicationName()
    {
    	return $this->controller;
    }
    
    /**
     * Returns the current (running) Action's name.
     *
     * @var string 
     */
    public function getActionName()
    {
    	return $this->action;
    }

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
	 * Changes the value of a specific segment using an index, or appends a new
	 * segment at the end.
	 *
	 *
	 * @method	setSegment(string $value)
	 * 			setSegment(int $n, string $value)
	 * @return	void
	 */
	public function setSegment()
	{
		$args = func_get_args();
		$total= func_num_args();
		
		if ($total==1) {
			if (is_string($args[0]))
				self::$segments[] = $args[0];
		} else if ($total==2) {
			$n		= $args[0];
			$value	= $args[1];
			if (array_key_exists($n-1, self::$segments))
				self::$segments[$n-1] = $value;
		}
	}
	
	/**
	 * Sets the new segments based on the array, or merges with the current segments.
	 *
	 * @param	array	$segm
	 * @param	boolean	$merge
	 * @return	void
	 */
	public function setSegments(array $segm, $merge=FALSE)
	{
		if ($merge==TRUE)
			self::$segments = array_merge (self::$segments, $segm);
		else 
			self::$segments = $segm;
	}
    
    /**
     * Returns the total number of segments.
     *
     * @return  integer
     */
	public function getSegmentsSize()
	{
	    return sizeof(self::$segments);
	}
	
	/**
	 * Removes the segment with the specified index number.
	 *
	 * @param	integer	$n
	 * @return	void
	 */
	public function removeSegment($n)
	{
		if (array_key_exists($n-1, self::$segments))
			unset (self::$segments[$n-1]);
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
		
		$returnStr = "/";
		
		for ($i=0; $i<$total; $i++)
		  $returnStr .= self::$segments[$i] . "/";
		
		return $returnStr;
	}

    /**
     * Returns the segments as an array.
     *
     * @return  array|NULL
     */
    public function getSegmentsAsArray()
    {
        return self::$segments;
    }
	
	/**
	 * Sets the new query string based on an associative array.
	 *
	 * @param	array	$queryString
	 * @return	void
	 */
	public function setQueryString(array $queryString)
	{
		self::$queryString = $queryString;
	}
    
	/**
	 * Returns the current query string, with the "?".
	 *
	 * @param	array	$replace
	 * @return	string
	 */
    public function getQueryString(array $replace=NULL)
    {
		if ($replace!=NULL)
			foreach ($replace as $Key => $Value)
				self::$queryString[$Key] = $Value;
		
		if (!empty(self::$queryString)) {
			$str = "?";
			
			for ($i=0; $i<sizeof(self::$queryString); $i++) {
				list($key, $value) = each (self::$queryString);
				
				if ($value!="") {
					$str .= $key . "=" . $value;
				} else {
					$str .= $key;
				}
				
				if ($i<sizeof($_GET)-1)
					$str .= "&";
			}
			
			if ($this->Config['enable_auto_xss']==TRUE)
				return $this->Xss->filter($str);
			else
				return $str;
		} else {
			return NULL;
		}
    }
	
	/**
	 * Appends a key/value to the current query string.
	 *
	 * @param	string	$key
	 * @param	string	$value
	 * @return	void
	 */
	public function append($key, $value)
	{
		self::$queryString[$key] = $this->Xss->filter($value);
	}
    
    /**
     * Checks if a form post event is triggered. If that is the case, the method
     * "handlePost" of the specific Controller will be called.
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
    private function headerExists($header)
    {
        if (!empty(self::$headers))
            return array_key_exists($header, self::$headers);
        else
            return NULL;
    }

    /**
     * Returns the contents of a header.
     *
     * @param   string  $header
     * @return  string|NULL
     */
    public function getHeader($header)
    {
        if ($this->headerExists($header))
            return self::$headers[$header];
        else
            return NULL;
    }

}

