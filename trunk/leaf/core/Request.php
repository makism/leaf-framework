﻿<?php
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
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Possible implementation of {@link http://en.wikipedia.org/wiki/Facade_pattern facade} functions.</li>
 * </ol>
 */
final class leaf_Request extends leaf_Base {

    const LEAF_REG_KEY = "Request";
    
    const LEAF_CLASS_ID = "LEAF_REQUEST-1_0_dev";


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
     * Internally uses the class {@link leaf_Router} in order to export
     * information like, the Controller name, the Controller`s name as 
     * is <i>must</i> be, the Action, etc.
     *
     * @return  void
     */
	public function __construct()
	{
        parent::__construct(self::LEAF_REG_KEY);

        /*
         * All classes that contain Controllers, must have their name
         " suffixed with the string "_Controller".
         * So, we attach it to the requested Controller.
         */
        $this->controller   = $this->Router->getClassName() . '_Controller';

        /*
         * Compose the complete file name where we suppose the Controller
         * is located.
         */
        $this->controllerFile =
            LEAF_APPS
            . $this->Router->getClassName()
            . '/'
            . $this->controller
            . '.php';

        /*
         * Fetch the Action from the {@link leaf_Router router} object.
         */
        $this->action       = $this->Router->getMethodName();

        /*
         * Fetch the extra Uri segments from the {@link leaf_Router router} object.
         */
        $this->segments     = $this->Router->segments();

        /*
         * Fetch the Query String from the {@link leaf_Router router} object.
         */
        $this->queryElems   = $this->Router->queryStringElements();
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
     * 
     *
     * @var string 
     */
    public function getActionName()
    {
    	return $this->action;
    }
    
	/**
	 * Performs a redirect to the speficied Uri.
     *
	 * @param	string	$target
	 * @param	boolean	$isExternal
	 * @return	void
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
	 */
	public function redirect($target, $isExternal=FALSE)
	{
	
	}
	
	/**
	 * Reconstructs a Uri, based on the data passed.
     *
	 * @param	string	$className
	 * @param	string	$methodName
	 * @param	array	$segments
     * @param   array   $queryString
	 * @return	string
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
	 */
	public function recostructUrl
		($className = NULL,
         $methodName = NULL,
         array $segments = NULL,
         array $queryString = NULL)
	{
	
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
	    if (array_key_exists($n+1, $this->segments))
	       return $this->segments[$n+1];
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
     * Returns the complete query string.
     * 
     * @var array
     */
    public function getQueryString()
    {
    	return $this->Router->queryString();
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
            else
                return NULL;
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
    public function getQueryStringAsString()
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

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

}

?>