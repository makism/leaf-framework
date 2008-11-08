<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf\Core;
use leaf\Base;


/**
 * Allows the Core objects to communicate with each other.
 * 
 * This is accompliced by having every application store all Core objects,
 * Models, Extensions etc to Registry that is associated with it.
 *
 * @package	    leaf
 * @subpackage	core
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version	    SVN: $Id$
 */
abstract class Common {

    /**
     * An instance of leaf_Registry, that stores all the
     * Core objects and Models for a specific application.
     *
     * @var object leaf_Registry
     */
    private $controllerRegistry = NULL;
    
    /**
     * 
     * 
     * @var array
     */
    private $allowedAccessors = array (
        "Dispatcher", "Router", "LocalLoader", "Request",
        "Model", "Controller", "View"
    );
    
    
    /**
     * 
     * 
     *
     * @var array
     */
    private $allowedSettors = NULL;


    /**
     * Creates a new Registry for the specified Controller.
     *
     * @param   string  $regName
     * @return  void
     */
    public function __construct($regName)
    {
        $this->controllerRegistry = Registry::getInstance($regName);
        array_push($this->allowedAccessors, $regName . "_Controller");
        $this->allowedSettors = &$this->allowedAccessors;
    }
    
   	/**
     * Fetches a Core object, a Base object or a Model. 
     * 
	 * @param  string  $Id
	 * @return object|NULL
	 */
	public function __get($Id)
	{
	   # if (in_array(get_called_class(), $this->allowedAccessors)) {
            if ($this->controllerRegistry->registered($Id)) {
                return $this->controllerRegistry->$Id;
            } else if (leaf\Base\Base::exists($Id)) {
                return leaf\Base\Base::fetch($Id);
            } else {
                if ($this->controllerRegistry->Local->modelLoaded($Id))
                    return $this->controllerRegistry->Local->model($Id);
            }
	   # }
	}
    
    /**
     * Stores an Object using the specified id.
     *
     * @param   string  $Id
     * @param   object  $Obj
     * @return  void
     */
    public function __set($Id, $Obj)
    {
       # if (in_array(get_called_class(), $this->allowedSettors)) {
            $this->controllerRegistry->register($Id, $Obj);
       # }
    }

}


