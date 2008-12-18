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
 * Provides a common base layout for all Models.
 *
 * @package 	leaf
 * @subpackage	core
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version	    SVN: $Id$
 * @todo
 * <ol>
 *  <li>For security issues, we should restrict it's access
 *  to specific resources?</li>
 * </ol>
 */
abstract class leaf_Model extends leaf_Common {

    /**
     * Associates this model with the specified controller.
     * 
     * @return  void
     */
    public function __construct($controllerName)
    {
        parent::__construct($controllerName);
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
     * @return  void
     */
    private function __clone()
    {
    
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

