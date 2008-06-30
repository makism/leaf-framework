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
 *
 *
 * @package	    leaf
 * @subpackage	core
 * @author  	Avraam Marimpis <makism@users.sf.net>
 * @version	    SVN: $Id$
 */
abstract class leaf_Common {

    /**
     *
     *
     * @var object leaf_Registry
     */
    private $controllerRegistry = NULL;


    /**
     *
     *
     * @param   string  $regName
     * @return  void
     */
    public function __construct($regName)
    {
        $this->controllerRegistry = leaf_Registry::getInstance($regName);
    }
    
    /**
     *
     * 
     * @param  string  $Id
     * @return object|NULL
     */
    protected function __get($Id)
    {
        if ($this->controllerRegistry->registered($Id)) {
            return $this->controllerRegistry->$Id;
        } else if (leaf_Base::exists($Id)) {
            return leaf_Base::fetch($Id);
        } else {
            if ($this->controllerRegistry->Local->modelLoaded($Id))
                return $this->controllerRegistry->Local->model($Id);
        }
    }
    
    /**
     *
     *
     * @param   string  $Id
     * @param   mixed   $Obj
     * @return  void
     */
    protected function __set($Id, $Obj)
    {
        $this->controllerRegistry->register($Id, $Obj);
    }

}


