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
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @see         leaf_Router
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Possible implementation of {@link http://en.wikipedia.org/wiki/Facade_pattern facade} functions.</li>
 * </ol>
 */
final class leaf_Request extends leaf_Base {

    const LEAF_REG_KEY = "request";
    
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
        $this->controller   = $this->router->getClassName() . '_Controller';

        /*
         * Compose the complete file name where we suppose the Controller
         * is located.
         */
        $this->controllerFile =
            LEAF_APPS
            . $this->router->getClassName()
            . '/'
            . $this->controller
            . '.php';

        /*
         * Fetch the Action from the {@link leaf_Router router} object.
         */
        $this->action       = $this->router->getMethodName();

        /*
         * Fetch the extra Uri segments from the {@link leaf_Router router} object.
         */
        $this->segments     = $this->router->segments();

        /*
         * Fetch the Query String from the {@link leaf_Router router} object.
         */
        $this->queryElems   = $this->router->queryStringElements();
	}

	/**
	 * ReturnstThe requested class name (Controller), suffixed with
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
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
     */
	public function totalSegments()
	{
	
	}
	
    /**
     * Retrieves the requested (numeric) offset from the segments.
     *
     * @param   integer $n
     * @return  string|NULL
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
     */
	public function segment($n)
	{
	
	}

    /**
     * Returns the segments` array.
     *
     * @return  array
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
     */
    public function segmentsAsArray()
    {

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
        if ($this->queryElems!=NULL)
            if (array_key_exists($offset, $this->queryElems))
                return $this->queryElems[$offset];
            else
                return NULL;
    }

    /**
     * Return the current query string, as a string.
     *
     * @return  string
	 * @todo
	 * <ol>
	 *  <li>Possible method complete refactor.</li>
	 * </ol>
     */
    public function getQueryStringAsString()
    {
        if ($this->queryElems!=NULL) {
            $str = NULL;
        
            foreach($this->queryElems as $Var => $Val)
                $str .= $Var . " = " . $Val . ",";

			if ($str{strlen($str)-1}==",")
				$str{strlen($str)-1} = " ";

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
