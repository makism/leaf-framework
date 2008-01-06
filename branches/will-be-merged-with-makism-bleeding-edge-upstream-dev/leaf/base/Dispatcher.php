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
final class leaf_Dispatcher extends leaf_Base {

    const BASE_KEY = "Dispatcher";


    /**
     * 
     *
     * @var array
     */
    private static $dispatchObjects = array();
    
    /**
     *
     *
     * @var object StdClass
     */
    public static $dispatchObject = NULL;

    
    /**
     *
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::BASE_KEY, $this);
    }
    
    /**
     * Checks for the existence of the desired method and calls it.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @return  void
     */
	public static function invoke($Controller, $Action=NULL)
	{
        if ($Action!="init" && $Action!="destroy") {
            self::prepare($Controller, $Action);
            
            $ControllerObject = array_pop(self::$dispatchObjects);
            
            self::call($ControllerObject, "init");
            
            self::call($ControllerObject, $ControllerObject->action);
            
            self::call($ControllerObject, "destroy");
        } else {
            showHtmlMessage(
                "Dispatcher Failure",
                "Direct call to method \"{$Action}\" is not allowed.",
                TRUE
            );
        }
	}
    
    private static function call($ControllerObject, $Action)
    {
        if (method_exists($ControllerObject->instance, $Action)) {
            
            if (extension_loaded('reflection')) {
                $refl = new ReflectionMethod (
                    $ControllerObject->controller,
                    $Action
                );
                
                if ($refl->getNumberOfParameters()==2) {
                    $app = $ControllerObject->application;
                    
                    call_user_func(
                        array(
                            $ControllerObject->instance,
                            $Action
                        ),
                        leaf_Registry::getInstance($app)->Request,
                        leaf_Registry::getInstance($app)->Response
                    );
                    
                    return;
                }
            }
            
            call_user_func(
                array(
                    $ControllerObject->instance,
                    $Action
                )
            );
            
        } else {
            showHtmlMessage(
                "Dispatcher Failure",
                "Action \"{$Action}\" is not defined",
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
        
        $dispatchObj->action = (isset($Action)) ? $Action : "index";
        
        list($canonicalName, $suffix) = explode("_Controller", $dispatchObj->controller);
        
        $dispatchObj->application = $canonicalName;
        
        $dispatchObj->target = LEAF_APPS
                            . $canonicalName
                            . '/'
                            . $Controller
                            . '.php';

        array_push(self::$dispatchObjects, $dispatchObj);
        self::$dispatchObject = $dispatchObj;
        
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
