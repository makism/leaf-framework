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
 * Prepares to dispatch the speficief Controller/Action.
 *
 * Includes the file that the requested Controller is declared, and
 * performs some basic checks in the Controller`s implementation and
 * naming scheme.<br>
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Remove member properties.</li>
 * </ol>
 */
final class leaf_Dispatcher extends leaf_Base {
	
    const LEAF_REG_KEY = "Dispatcher";
    
    const LEAF_CLASS_ID = "LEAF_DISPATCHER-1_0_dev";
    

    /**
     * The file name in which the requested Controller is located.
     *
     * For more info take a look at the class leaf_Request.
     *
     * @var string
     */
    private $target = NULL;

    /**
     * The requested class name (Controller).
     *
     * For more info take a look at the class leaf_Request.
     *
     * @var string
     */
    private $controllerName = NULL;

    /**
     * An instance of the requested Controller.
     *
     * @var object leaf_Controller
     */
    private $controller = NULL;


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
         * Get Controller`s name :).
         */
        $this->controllerName = $this->Request->getControllerName();

        /*
         * Get Controller`s file name.
         */
        $this->target = $this->Request->getControllerFileName();

        /*
         * Check if the Controller`s file, exists.
         */
        if (!file_exists($this->target))
            showHtmlMessage("Dispatcher Failure", "Controller \"{$this->controllerName}\", not found!", TRUE);
        
        /*
         * Include the file, in which the requested Controller
         * is declared.
         */
        require_once $this->target;

        /*
         * Register and instance of leaf_View, for future usage.
         */
        leaf_Registry::getInstance()->register(new leaf_View());

        /*
         * Create an instance of the requested Controller.
         */
        $this->controller = new $this->controllerName;

        /*
         * Check if the current Controller inherits from our
         * class, leaf_Controller.
         */
        if (!($this->controller instanceof leaf_Controller)) {
            showHtmlMessage("Dispatcher Failure", "Not a controller", TRUE);
        }
    }
    
    /**
     * Checks for the existence of the desired method and calls it.
     *
     * @return  void
     */
	public function dispatchController()
	{
        if (method_exists($this->controller, $this->Router->getMethodName())) {
            call_user_func(array($this->controller, $this->Router->getMethodName()));
        } else {
            showHtmlMessage("Dispatcher Failure", "Action \"{$this->Router->getMethodName()}\" is not defined", TRUE);
        }
	}

    public function __toString()
    {
        return __CLASS__ . " (Dispatches the requested Action)";
    }

}

?>
