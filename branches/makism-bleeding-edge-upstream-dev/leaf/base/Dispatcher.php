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
    private $dispatchObjects = array();
    
    /**
     *
     *
     * @var object StdClass
     */
    public $dispatchObject = NULL;

    /**
     *
     *
     * @var string
     */
    private $applicationObject = NULL;
    

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
	public function invoke($Controller=NULL, $Action=NULL)
	{
        if ($Action!="init" && $Action!="destroy") {

            if ($Controller!=NULL)
                $this->prepare($Controller, $Action);
            
            if ($Controller==NULL && empty($this->dispatchObjects))
                showHtmlMessage(
                    "Dispatcher Error.",
                    "No Controller found in the stack to dispatch.",
                    TRUE
                );
            
            $ControllerObject = array_pop($this->dispatchObjects);

            // Store the main application controller name.
            if ($this->applicationObject==NULL)
                $this->applicationObject = $ControllerObject->controller;

            // Check if the current controller if it`s not the main
            // controller and allows to be called from another one.
            if ($this->applicationObject!=$ControllerObject->controller) {
                if (constant("{$ControllerObject->controller}::ALLOW_CALL")==FALSE) {
                    showHtmlMessage(
                        "Dispatcher Error.",
                        "Requested controller {$ControllerObject->controller} " .
                        "can not be invoked externally.",
                        TRUE
                    );
                }
            }

            // Init the Controller
            $this->call($ControllerObject, "init");
            
            $ControllerObject->instance->Response->ouputBufferStart();
            
            // Execute requested Action
            $this->call($ControllerObject, $ControllerObject->action);
            
            $ControllerObject->instance->Response->outputBufferFlush();
            
            // Destroy the Controller
            $this->call($ControllerObject, "destroy");
            
        } else {
            showHtmlMessage(
                "Dispatcher Failure",
                "Direct call to method \"{$Action}\" is not allowed.",
                TRUE
            );
        }
	}
    
    private function call($ControllerObject, $Action)
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
	public function prepare($Controller, $Action=NULL, $fetch=FALSE)
	{
        static $traceDispatches;
        
        if ($traceDispatches==NULL) {
            $routes = $this->Config->fetchArray("routes");
            $traceDispatches = $routes['trace_dispatches'];
            unset($routes);
        }
    
        if (strrpos($Controller, "_Controller")==FALSE)
            $Controller .= "_Controller";
        
        $dispatchObj = new StdClass();
        
        $dispatchObj->caller = NULL;
        
        if ($traceDispatches==TRUE)
            if ($this->dispatchObject!=NULL)
                $dispatchObj->caller = $this->dispatchObject;
        
        $dispatchObj->controller = $Controller;
        
        $dispatchObj->action = (isset($Action)) ? $Action : "index";
        
        list($canonicalName, $suffix) = explode("_Controller", $dispatchObj->controller);
        
        $dispatchObj->application = $canonicalName;
        
        $dispatchObj->target = LEAF_APPS
                            . $canonicalName
                            . '/'
                            . $Controller
                            . '.php';

        array_push($this->dispatchObjects, $dispatchObj);
        $this->dispatchObject = $dispatchObj;
        
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
     * @param   boolean $popFromStack
     * @return  boolean
     */
    public function pretend($Controller, $Action=NULL, $popFromStack=FALSE)
    {
        $obj = $this->prepare($Controller, $Action, TRUE);
        
        if ($obj!=NULL) {
            if (method_exists($obj->instance, $obj->action)) {

                if ($popFromStack==TRUE)
                    $this->clear();

                return TRUE;
            }
        }

        $this->clear();
            
        return FALSE;
    }

    /**
     *
     *
     * @return  void
     */
    private function clear()
    {
        $this->dispatchObject = NULL;
        array_pop($this->dispatchObjects);
    }
    
    public function __toString()
    {
        return __CLASS__ . " (Dispatches the requested Controller/Action)";
    }
    
}

