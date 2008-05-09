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
 * Processes and filters the current Uri.
 *
 * Filters the Uri for erroneous characters, splits the query string
 * (if enabled), matches the virtual file extension (if enabled),
 * discovers the requested Controller(class) and the Action(method).
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Maybe this class should completely overtake the class {@link
 *  leaf_Request}, thus removing the later class.</li>
 *  <li>Provide an alternative class (which maybe will inherit from this
 *  one) that will use static routing rules.</li>
 * </ol>
 */
final class leaf_Router extends leaf_Base {

    const LEAF_REG_KEY = "router";
    
    const LEAF_CLASS_ID = "LEAF_ROUTER-1_0_dev";


	/**
     * The current requested Uri string.
     *
     * @var string
     */
	private $requestUri = NULL;
	
	/**
     * The requested class name (Controller).
     *
     * @var string
     */
	private $requestClass = NULL;
	
	/**
     * The requested method name (Action).
     *
     * @var string
     */
	private	$requestMethod= NULL;
	
	/**
     * The extra segments found in the Uri.
     *
     * Whatever follows after the method name,
     * and is separated by "/", is considered
     * to be a segment.<br>
     * Example:<br>
     * <i>http://localhost/Blog/view/2007/xx/xx/aTitle/</i><br>
     * The array $segments, will be populated by the strings:<br>
     * "2007", "xx", "xx", "aTitle"
     *
     * @var array
     */
	private $segments = NULL;
	
	/**
     * The query string found in the Uri.
     *
     * If enabled in the general configuration file, and if
     * found in the Uri, the query string is separated and
     * processed so it produces the array $queryStringElements.
     *
     * @var string
     */
	private $queryString = NULL;
	
	/**
     * The query string found in the Uri, as an associative array.
     *
     * @var array
     */
	private $queryStringElements = NULL;

	
	/**
     * Ελληνική μετάφραση πάει εδώ...
	 *
	 * @see		leaf_Config
	 * @see		leaf_Request
	 * @return	void
     * @todo
     * <ol>
     *  <li>Possible break-down of the jobs that the constructor executes.</li>
     *  <li>Recheck the "virtual file extension" function.</li>
     * </ol>
	 */
	public function __construct() {
        
        parent::__construct(self::LEAF_REG_KEY);
	    
		$this->requestUri   = $_SERVER['REQUEST_URI'];

        /*
         * Replace the possible multiple occurences of "/", with one "/"
         */
        $this->requestUri = preg_replace("@/+@i", "/", $this->requestUri);
        
		/*
		 * We check if there are any illegal characters in
		 * the Uri that they shouldn`t.
		 * Moreover, we take into consideration if the option
		 * $this->config['url_suffix'] is used which defines the file
		 * extensions that will be shown, so we ignore it.
		 */
        // match the virtual file extension.
		/*$skipExt = (!empty($this->config['url_suffix']))
					? "(\.[^?=&]+)?"
					: "";*/
        $skipExt = "";
		
        // match the query string
		$skipQueryString = ($this->config['allow_query_strings']=="Yes")
			? "(\?(["
				. $this->config['allow_query_string_chars']
				. "]+(=["
				. $this->config['allow_query_string_chars']
				. "]*)?\&?)+)?"
			: "";
		
        // match all
		$checkUri = preg_match_all(
			"|"
				. "^[" . preg_quote($this->config['allow_uri_chars']) . "]+"
				. "{$skipExt}{$skipQueryString}$" .
			"|iu",
			$this->requestUri,
			$hits
		);
		
        /*
         * We die in case we find erroneous characters in the Uri,
         * and keep a log of the event.
         */
		if ($checkUri==0) {
		    /*$this->logger->log(
		        "Error",
		        "Routing Error, Malicious characters found in Uri ("
		        . "{$this->requestUri})"
		    );*/
		    
			showHtmlMessage(
			    "Routing Error",
			    "Malicious characters found in Uri!",
			    true
			);
		}
		
		/*
		 * We check if there is a query string in our uri.
		 * We process it in an associative array way.
		 * Either way, we remove the query string from the
		 * request uri.
		 */
		if (preg_match("@\?(.+(=.+)?\&?$)+@iu", $this->requestUri, $matches)) {
            
			if ($this->config['allow_query_strings']=="Yes") {
                
				$this->queryString = $matches[0];

				$keysWithValues = explode("&", $matches[1]);

				foreach ($keysWithValues as $Elem) {

                    if (strpos($Elem, "=")) {
            			list($Key, $Value) = explode("=", $Elem);                
            			$this->queryStringElements[$Key] = $Value;
                    } else {
                        $this->queryStringElements[$Elem] = NULL;
                    }
				}
                
				$this->requestUri = preg_replace(
					"|"
						. preg_quote($this->queryString) .
					"|iu",
					"",
					$this->requestUri
				);
                
			} else {
				$this->requestUri = preg_replace(
					"|" . preg_quote($matches[0]) . "|i",
					"",
					$this->requestUri
				);
			}
		}

		
		/*
		 * Removal of leading base dir.
		 */
		$this->requestUri = preg_replace(
			"@^{$this->config['base_dir']}@",
			"",
			$this->requestUri
		);
		
		/*
		 * Removal of the virtual file extension
         * if enabled, and if found in the Uri.
		 */
		if (!empty($this->config['url_suffix']))
			$this->requestUri = preg_replace(
				"@\.{$this->config['url_suffix']}/?$@",
				"",
				$this->requestUri
			);
		
		/*
		 * Removal of trailing '/' (if exists in Uri).
		 */
		if (preg_match("@/$@", $this->requestUri))
			$this->requestUri = preg_replace("@/$@", "", $this->requestUri);

		/*
		 * If no class is defined instatiate the default Controller.
		 */
		if ($this->requestUri=="/"	||
			$this->requestUri==NULL	||
			($this->requestUri{0}=="?" && $this->config['allow_query_strings']=="Yes")) {
			$this->requestClass = $this->config['default_controller'];
        }	
		/*
		 * We extract the Controller class.
		 */
		else {
			$this->chopSegment($this->requestClass);
        }
		
		/*
		 * We extract the method (if defined).
		 */
		$this->chopSegment($this->requestMethod);
		if ($this->requestMethod==NULL) {
		    $this->requestMethod = "index";
        }
		
		/*
		 * If there are more segments in the Uri, except from the
		 * class name and the method name, we store those segments
		 * in an array and we provide them at the user`s disposal.
		 */
		$segments = explode("/", $this->requestUri);
		foreach ($segments as $s) {
			if ($s!=null)
				$this->segments[] = $s;
		}
		
	}

    /**
     * Returns an associative array filled with the
     * elements that found in the query string.
     * 
     * @see     leaf_Request
     * @return  array|NULL
     */
    public function queryStringElements()
    {
        return $this->queryStringElements;
    }
	
	/**
     * Returns the total number of segments that found
     * in the current Uri.
	 *
	 * @return	integer
	 */
	public function segmentsSize()
	{
		return sizeof($this->segments);
	}
	
	/**
     * Returns an array with the extra segments
     * that compose this Uri.
	 *
     * @see     leaf_Request
	 * @return	array|NULL
	 */
	public function segments()
	{
		return $this->segments;
	}

	/**
     * Removes the first string occurence until the very first
     * "/", from the property $this->requestUri.
	 *
	 * @param	string	$seg
	 * @return	void
	 */
	private function chopSegment(&$seg)
	{
		if ($this->requestUri!="") {
			if (preg_match("@([^/\?]*)@", $this->requestUri, $hits)) {
				$seg = $hits[0];
				$this->requestUri = preg_replace("@([^/\?]*/?)@", "", $this->requestUri, 1);
			}
		}
	}
	
	/**
     * Returns the class name (Controller) that is requested.
	 *
     * @see     leaf_Request
	 * @return  string
	 */
	public function getClassName()
	{
		return $this->requestClass;
	}
	
	/**
     * Returns the method name (Action) that is requested.
     *
     * @see     leaf_Request
	 * @return  string
	 */
	public function getMethodName()
	{
		return $this->requestMethod;
	}

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

}

?>
