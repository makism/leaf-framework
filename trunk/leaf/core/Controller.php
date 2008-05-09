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
 * Assigns some common characteristics to all user`s Controllers.
 *
 * All Controllers, <b>must</b> inherit from this class, otherwise
 * they will be <b>ignored</b>.
 *
 * @package 	leaf
 * @subpackage	core
 * @author	    Avraam Marimpis <makism@users.sf.net>
 * @version 	SVN: $Id$
 */
/**
 * Assigns some common characteristics to all user`s Controllers.
 *
 * All Controllers, <b>must</b> inherit from this class, otherwise
 * they will be <b>ignored</b>.
 *
 * @package     leaf
 * @subpackage  core
 * @author      Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version     SVN: $Id$
 */
abstract class leaf_Controller extends leaf_Common {

    /**
     * Allow other Controllers to call this one.
     *
     * @var boolean
     */
    const ALLOW_CALL = TRUE;

    /**
     * Enable/Disable the Application.
     *
     * @var boolean
     */
    const IS_ENABLED = TRUE;

    /**
     * Restrict Controller access only to localhost.
     *
     * @var boolean
     */
    const RESTRICT_ACCESS = FALSE;

    /**
     * Enable/Disable hooks.
     *
     * @var boolean
     */
    const ALLOW_HOOKS = TRUE;

    /**
     * Set the desired output buffer handler.
     *
     * Legal values: "gzip", "bz2", "tidy", ""
     *
     *
     * @var string
     */
    const OUTPUT_HANDLER = "";


    /**
     * Controller`s name.
     *
     * @var string
     */
    private $controllerName = NULL;


    /**
     * Calls the parent constructor and registers the basic
     * objects needed for this Application.
     *
     * @return  void
     */
    public function __construct($controllerName)
    {
        parent::__construct($controllerName);
        
        $this->__set("Request", new leaf_Request($controllerName));
        $this->__set("Local",new leaf_LocalLoader($controllerName));
        $this->__set("Response", new leaf_Response($controllerName));   
        $this->__set("View", new leaf_View($controllerName));

        $this->controllerName = $controllerName;
    }
    
    /**
     * Destructor.
     *
     * @return  void
     */
    public function __destruct()
    {
        
    }
    
    /**
     * Prevent object cloning.
     *
     * @return  void
     */
    private function __clone()
    {
    
    }
    
    /**
     * Return an informative string, when the Controller is "printed".
     *
     * @return  string
     */
    public function __toString()
    {
        return
            $this->Request->getControllerName() . "/" .
            $this->Request->getActionName();
    }

}

