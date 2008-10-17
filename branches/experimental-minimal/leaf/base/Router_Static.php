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
final class Router_Static extends Base {

    const BASE_KEY = "Router";
    
    
    private $routeOptions = NULL;
    
    private $segments = NULL;
    
    private $requestClass = NULL;
    
    private $requestMethod = NULL;
    
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
    
    public function segments()
    {
        return $this->segments;
    }
    
    public function getClassName()
    {
        return $this->requestClass;
    }
    
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

