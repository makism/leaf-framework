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
abstract class leaf_Controller extends leaf_Common {

    /**
     *
     *
     * @var boolean
     */
    const ALLOW_CALL = TRUE;


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
	}
    
    /**
     *
     *
     * @return  void
     */
    public function __destruct()
    {
        
    }
    
    /**
     *
     *
     * @return  void
     */
    private function __clone()
    {
    
    }
    
    /**
     *
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

