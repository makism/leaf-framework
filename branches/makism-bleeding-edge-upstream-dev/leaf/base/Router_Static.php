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
 * Processes and filters the current Uri in a static-like way.
 * 
 * This means that the user has defined some static rules
 * that will reflect the Uri. Nothing is done dynamic so
 * less resources are used.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
final class leaf_Router_Static extends leaf_Base {

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
        
        $this->requestUri = substr($_SERVER['REQUEST_URI'], strlen($this->Config['base_dir']));
        #var_dump ($this->requestUri);
        
        $this->routeOptions = $this->Config->fetchArray("route");
        
        if ($this->requestUri==FALSE) {
            $this->requestClass = $this->routeOptions['default_route'];
            $this->requestMethod = "index";
        } else {
            // class
            $start_of_method = strpos($this->requestUri, "/");
            
            if ($start_of_method==FALSE)
                $this->requestClass = $this->requestUri;
            else
                $this->requestClass = substr($this->requestUri, 0, strpos($this->requestUri, "/"));
            
            // extract segment after the classname
            $tmp1 = substr($this->requestUri, strlen($this->requestClass)+1);
            // until we reach a "/"
            $end_of_method = strpos($tmp1, "/");

            if ($end_of_method==FALSE)
                $tmp2 = $tmp1;
            else
                $tmp2 = substr($tmp1, 0, $end_of_method);
            
            // ignore the virtual file extension (if any)
            if ($dot=strpos($tmp2, "."))
                $tmp2 = substr($tmp2, 0, $dot);
            
            $this->requestMethod = $tmp2;
            
            if ($this->requestMethod==FALSE)
                $this->requestMethod = NULL;
                
            if ($end_of_method!=FALSE) {
                $raw_segments = substr($tmp1, $end_of_method);
                $segments = NULL;
                
                if (empty($_GET)) {
                    $segments = explode("/", substr($tmp1, $end_of_method+1));
                } else {
                    $tmp1 = substr($tmp1, $end_of_method+1);
                    $segments = explode("/", substr($tmp1, 0, strpos($tmp1, "?")));
                }
                
                if ($segments!=NULL) {
                    foreach ($segments as $s) {
                        if ($s!=NULL) {
                            $this->segments[] = $s;
                        }
                    }
                }
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

