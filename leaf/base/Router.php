<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf::Base;
use leaf::Base::Base;


/**
 * Processes and filters the current Uri.
 *
 * Filters the Uri for erroneous characters, splits the query string
 * (if enabled), matches the virtual file extension (if enabled),
 * discovers the requested Controller(class) and the Action(method).
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
class Router extends Base {

    const BASE_KEY = "Router";

    
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
    private $requestMethod= NULL;
    
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
	 * The configuration options related with the Router.
	 *
	 * @var array
	 */
    private $routeOptions = NULL;

    
	/**
	 * Registers Router, and begins a series of checks in the Uri to discover the Controller etc.
	 * 
	 * @return  void
	 */
    public function __construct()
    {
        parent::__construct(self::BASE_KEY, $this);
        
        $this->requestUri = $_SERVER['REQUEST_URI'];
        
        $this->routeOptions = $this->Config->fetchArray("route");
		
		/*
		 * Check if the the method separator character is a legal value.
		 */
        if ($this->routeOptions['method_separator']!="." &&
            $this->routeOptions['method_separator']!="/")
        {
            // Show the error
            showHtmlMessage(
                $this->Locale->getError('Route', 'RouteConfError'),
				sprintf(
					$this->Locale->getError('Route', 'RouteConfMethodSepError'),
					$this->routeOptions['method_separator']
				),
                TRUE
            );
        }
		
		/*
		 *
		 */
		$this->checkRequestUri();
        
		/*
		 * We check if there is a query string in our uri.
		 * We process it in an associative array way.
		 * Either way, we remove the query string from the
		 * request uri.
		 */
		$this->extractQueryString();
        
        
		/*
		 * Removal of leading base dir.
		 */
        $this->requestUri = preg_replace(
            "@^{$this->Config['base_dir']}@",
            "",
            $this->requestUri
        );
        
		/*
		 * Removal of the virtual file extension
		 * if enabled, and if found in the Uri.
		 */
		$this->extractVirtualFileExtension();
		
		/*
		 * Removal of trailing '/' (if exists in Uri).
		 */
        if (preg_match("@/$@", $this->requestUri))
            $this->requestUri = preg_replace("@/$@", "", $this->requestUri);
        
		$this->extractController();
        $this->extractAction();
		$this->extractSegments();
		
    }
		
	/*
	 * We check if there are any illegal characters in
	 * the Uri that they shouldn`t.
	 * Moreover, we take into consideration if the option
	 * $this->Config['url_suffix'] is used which defines the file
	 * extensions that will be shown, so we ignore it.
	 */
	protected function checkRequestUri()
	{
        // match the virtual file extension.
        $skipExt = (!empty($this->routeOptions['url_suffix']) &&
                    $this->routeOptions['method_separator']!=".")
                    ? "(\.[^?=&]+)?"
                    : "";
        
        // match the query string
        $skipQueryString = ($this->routeOptions['allow_query_strings'])
            ? "(\?(["
                . $this->routeOptions['allow_query_string_chars']
                . "]+(=["
                . $this->routeOptions['allow_query_string_chars']
                . "]*)?\&?)*)?"
            : "";

        // add the "method separator" character to list containing
        // the valid characters found in the Uri.
        if ($this->routeOptions['method_separator']!="/")
            $this->routeOptions['allow_uri_chars'] .=
                $this->routeOptions['method_separator'];
        
        // match all
        $checkUri = preg_match_all(
            "|"
                . "^[" . preg_quote($this->routeOptions['allow_uri_chars']) . "]+"
                . "{$skipExt}{$skipQueryString}$" .
            "|iu",
            $this->requestUri,
            $hits
        );
		
		/*
		 * We die in case we find erroneous characters in the Uri.
		 */
		if ($checkUri==0) {
           // By the time we enter this block, we no longer care
            // about performance, so we let loose :P
			
            // match the file extension (again).
            $ext = "(\.[^?=&]+)?";
			
            // match the query string (again).
            $QueryString = "(\?(["
                . $this->routeOptions['allow_query_string_chars']
                . "]+(=["
                . $this->routeOptions['allow_query_string_chars']
                . "]*)?\&?)*)?";
				
            // match all, extract the file extension and
            // the query string (if any of these exist).
            $tmp = preg_match_all(
                "|"
                    . "^[" . preg_quote($this->routeOptions['allow_uri_chars']) . "]+"
                    . "(?P<ext>{$ext})(?P<qstring>{$QueryString})$" .
                "|iu",
                $this->requestUri,
                $matches
            );
			
            // prepare a message to show
            $reasonMessage = "<hr color='#e0e0e0'/>";
			
            if (empty($this->routeOptions['url_suffix'])) 
                if (!empty($matches['ext'][0])) {
                    $reasonMessage =
						sprintf(
							$this->Locale->getError('Router', 'NotAllowedVFExtensions'),
							"<b>" . $matches['ext'][0] ."</b>"
						);
					$reasonMessage .= "<br />";
                }
				
            if ($this->routeOptions['allow_query_strings']==FALSE)
                if (!empty($matches['qstring'][0])) {
                    $reasonMessage =
						sprintf(
							$this->Locale->getError('Router', 'NotAllowedQueryStrings'),
							"<b>" . $matches['qstring'][0] ."</b>"
						);
					$reasonMessage .= "<br />";
                }
				
            // Show the error
            showHtmlMessage(
				$this->Locale->getError('Router', 'Error'),
				sprintf(
					$this->Locale->getError('Router', 'IlligalCharacters'),
					"<br /><small>" . $reasonMessage . "</small>"
				),
                TRUE
            );
		}
		
	}
 
	/**
	 * Extracts the Controller (if defined).
	 * 
	 * If no Controller is defined in the Uri, the default one is used
	 * (from the route.php configuration settings).
	 * 
	 * @return void
	 */
    protected function extractController() {
		/*
		 * If no class is defined instatiate the default Controller.
		 */
        if ($this->requestUri=="/"  ||
            $this->requestUri==NULL ||
            ($this->requestUri{0}=="?" && $this->routeOptions['allow_query_strings'])
            ) {
            $this->requestClass = $this->routeOptions['default_route'];
        }   
		/*
		 * We extract the Controller class.
		 */
        else {
            $this->chopSegment($this->requestClass);
        }
		
    }
    
    /**
     * Extracts the virtual file extension (if found and/or allowed).
     * 
     * @return  void
     */
    protected function extractVirtualFileExtension() {
		if (!empty($this->routeOptions['url_suffix']))
			$this->requestUri = preg_replace(
				"@\.{$this->routeOptions['url_suffix']}@",
				"",
				$this->requestUri
			);
    }
    
	/**
	 * Extract the method (if defined).
 	 *
 	 * @return	void
	 */
    protected function extractAction() {
        $this->chopSegment($this->requestMethod);
        if ($this->requestMethod==NULL) {
            $this->requestMethod = "index";
        }
		
    }
    
	/**
	 * If there are more segments in the Uri, except from the
	 * class name and the method name, we store those segments
	 * in an array and we provide them at the user`s disposal.
	 *
	 * @return	void
	 */
    protected function extractSegments() {
        $segments = explode("/", $this->requestUri);
        
        foreach ($segments as $s) {
            if ($s!=null) {
                $this->segments[] = $s;                
            }
        }
    }
    
    /**
     * Extracts the query string from the Uri (if found).
     * 
     * @return  void
     */
    protected function extractQueryString() {
       if (preg_match("@\?(.+(=.+)?\&?$)+@iu", $this->requestUri, $matches)) {
            
            if ($this->routeOptions['allow_query_strings']) {
                
                $this->queryString = $matches[0];
                
                $keysWithValues = explode("&", $matches[1]);
               
                foreach ($keysWithValues as $Elem) {
                    
                    if (strpos($Elem, "=")) {
                        list($Key, $Value) = explode("=", $Elem);
                        $_GET[$Key] = $Value;
                    } else {
                        $_GET[$Elem] = "";
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
    }

    
	/**
	 * Returns an array with the extra segments that compose this Uri.
	 *
	 * @see     leaf_Request
	 * @return  array|NULL
	 */
    public function segments()
    {
        return $this->segments;
    }

	/**
	 * Removes the first string occurence until the very first "/",
	 * from the property $this->requestUri.
	 *
	 * @param   string  $seg
	 * @return  void
	 */
    private function chopSegment(&$seg)
    {
        if ($this->requestUri!="") {
            if (preg_match(
                "@([^" . $this->routeOptions['method_separator'] . "\?]*)@",
                $this->requestUri, $hits
                )
            )
            {
                $seg = $hits[0];
                $this->requestUri = preg_replace(
                    "@([^" . $this->routeOptions['method_separator'] . "\?]*/?)@",
                    "",
                    $this->requestUri,
                    1
                );
            }
        }
    }
    
    /**
     * Returns the class name (Controller) that is requested (extracted from the Uri).
     * 
     * Do not mix with the current Controller that <b>is being executed</b>.
     *
     * @return  string
     */
    public function getClassName()
    {
        return $this->requestClass;
    }
    
    /**
     * Returns the method name (Action) that is requested (extracted from the Uri).
     * 
     * Do not mix with the current Action that <b>is being executed</b>.
     *
     * @return  string
     */
    public function getMethodName()
    {
        return $this->requestMethod;
    }
    
    /**
     *
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . " ()";
    }

}
