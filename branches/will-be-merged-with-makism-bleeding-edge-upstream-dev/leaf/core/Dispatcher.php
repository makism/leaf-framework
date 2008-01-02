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
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
final class leaf_Dispatcher extends leaf_Base {
	
    const LEAF_REG_KEY = "Dispatcher";
    
    const LEAF_CLASS_ID = "LEAF_DISPATCHER-1_0_dev";
    
    
    /**
     * Object containing the dispatching information.
     *
     * @var object StdClass
     */
    private $dispatchObject = NULL;
    
    
    /**
     * Tests the requested Controller and prepares for dispaching it, along
     * with the Action.
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
        
        /*
         * Register and instance of leaf_View, for future usage.
         */
        leaf_Registry::getInstance()->register(new leaf_View());
        
        /*
         * Prepare the main dispatch controller.
         */
        //$this->prepare($this->Request->getControllerName(), $this->Request->getActionName());
    }
    
    /**
     * Checks for the existence of the desired method and calls it.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @return  void
     */
	public function invoke($Controller, $Action=NULL)
	{
        $this->prepare($Controller, $Action);
        
        if (method_exists($this->dispatchObject->instance, $this->dispatchObject->action)) {
            
            if (extension_loaded('reflection')) {
                $refl = new ReflectionMethod (
                    $this->dispatchObject->controller,
                    $this->dispatchObject->action
                );
                
                if ($refl->getNumberOfParameters()==2) {
                    call_user_func(
                        array(
                            $this->dispatchObject->instance,
                            $this->dispatchObject->action
                        ),
                        $this->Request,
                        $this->Response
                    );
                    
                    return;
                }
            }
            
            call_user_func(
                array(
                    $this->dispatchObject->instance,
                    $this->dispatchObject->action
                )
            );
            
        } else {
            showHtmlMessage(
                "Dispatcher Failure",
                "Action \"{$this->dispatchObject->action}\" is not defined",
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
	public function prepare($Controller, $Action=NULL, $fetch=FALSE)
	{
        if (strrpos($Controller, "_Controller")==FALSE)
            $Controller .= "_Controller";
        
        $dispatchObj = new StdClass();
        
        $dispatchObj->controller = $Controller;
        
        $dispatchObj->action = (isset($Action) ? $Action : "index");
        
        list($canonicalName, $suffix) = explode("_Controller", $dispatchObj->controller);
        
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
        $dispatchObj->instance = new $dispatchObj->controller;
        
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
            $this->dispatchObject = $dispatchObj;
	}
    
    /**
     * Pretends an invoke call. Returns TRUE if all goes smooth
     * and FALSE in any other case.
     *
     * @param   string  $Controller
     * @param   string  $Action
     * @return  boolean
     */
    public function pretend($Controller, $Action=NULL)
    {
        $obj = $this->prepare($Controller, $Action, TRUE);
        
        if ($obj!=NULL) 
            if (method_exists($obj->instance, $obj->action))
                return TRUE;
            
        return FALSE;
    }

    public function __toString()
    {
        return __CLASS__ . " (Dispatches the requested Action)";
    }

}
