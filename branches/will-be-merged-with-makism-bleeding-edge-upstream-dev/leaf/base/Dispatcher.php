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
 * Prepares to dispatch the specific Controller/Action.
 *
 * Includes the file that the requested Controller is declared, and
 * performs some basic checks in the Controller`s implementation and
 * naming scheme.<br>
 *
 * @package		leaf
 * @subpackage	base
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
final class leaf_Dispatcher {

    /**
     * Object containing the dispatching information.
     *
     * @var object StdClass
     */
    private static $dispatchObject = NULL;
    
    
    /**
     * Checks for the existence of the desired method and calls it.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @return  void
     */
	public static function invoke($Controller, $Action=NULL)
	{
        self::prepare($Controller, $Action);
        
        // "init" the Controller
        call_user_func(
            array(
                self::$dispatchObject->instance,
                "init"
            )
        );
        
        if (method_exists(self::$dispatchObject->instance, self::$dispatchObject->action)) {
            
            if (extension_loaded('reflection')) {
                $refl = new ReflectionMethod (
                    self::$dispatchObject->controller,
                    self::$dispatchObject->action
                );
                
                if ($refl->getNumberOfParameters()==2) {
                    $app = self::$dispatchObject->application;
                    
                    call_user_func(
                        array(
                            self::$dispatchObject->instance,
                            self::$dispatchObject->action
                        ),
                        leaf_Registry::getInstance($app)->Request,
                        leaf_Registry::getInstance($app)->Response
                    );
                    
                    call_user_func(
                        array(
                            self::$dispatchObject->instance,
                            "destroy"
                        )
                    );
                    
                    return;
                }
            }
            
            call_user_func(
                array(
                    self::$dispatchObject->instance,
                    self::$dispatchObject->action
                )
            );
            
            call_user_func(
                array(
                    self::$dispatchObject->instance,
                    "destroy"
                )
            );
            
        } else {
            showHtmlMessage(
                "Dispatcher Failure",
                "Action \"{self::dispatchObject->action}\" is not defined",
                TRUE
            );
        }
	}
    
    /**
     * Dispatcher the defined Controller/Action.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @param   boolean $fetch
     * @return  NULL|object StdClass
     */
	public static function prepare($Controller, $Action=NULL, $fetch=FALSE)
	{
        if (strrpos($Controller, "_Controller")==FALSE)
            $Controller .= "_Controller";
        
        $dispatchObj = new StdClass();
        
        $dispatchObj->controller = $Controller;
        
        $dispatchObj->action = (isset($Action) ? $Action : "index");
        
        list($canonicalName, $suffix) = explode("_Controller", $dispatchObj->controller);
        
        $dispatchObj->application = $canonicalName;
        
        $dispatchObj->target = LEAF_APPS
                            . $canonicalName
                            . '/'
                            . $Controller
                            . '.php';
        
        /*
         * Check if the Controller`s file, exists.
         */
        if (!file_exists($dispatchObj->target)) {
            if ($fetch==TRUE)
                return NULL;
            
            showHtmlMessage(
                "Dispatcher Failure",
                "Controller \"{$dispatchObj->controller}\", not found!",
                TRUE
            );
        }
        
        /*
         * Include the file, in which the requested Controller
         * is declared.
         */
        require_once $dispatchObj->target;
        
        /*
         * Create an instance.
         */
        $dispatchObj->instance = new $dispatchObj->controller (
            $dispatchObj->application
        );
        
        /*
         * Check if the current Controller inherits from our
         * class, leaf_Controller.
         */
        if (!($dispatchObj->instance instanceof leaf_Controller)) {
            if ($fetch==TRUE)
                return NULL;
            
            showHtmlMessage("Dispatcher Failure", "Not a controller", TRUE);
        }
        
        if ($fetch==TRUE)
            return $dispatchObj;
        else
            self::$dispatchObject = $dispatchObj;
	}
    
    /**
     * Pretends an invoke call. Returns TRUE if all goes smooth
     * and FALSE in any other case.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @return  boolean
     */
    public static function pretend($Controller, $Action=NULL)
    {
        $obj = self::prepare($Controller, $Action, TRUE);
        
        if ($obj!=NULL) 
            if (method_exists($obj->instance, $obj->action))
                return TRUE;
            
        return FALSE;
    }

}
