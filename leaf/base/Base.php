<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf::Base;


/**
 * Allows internal classes to communicate with each other.
 * 
 * Every instance of the internal classes is stored within leaf_Base.
 * Thus, each class that inherits from leaf_Base, automatically has
 * access to all the other objects. 
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
abstract class Base {

    /**
     * Stores all the (internal) instances.
     *
     * @var array
     */
    private static $BaseObjects = array ();

    
    /**
     * When a class that inherits leaf_Base, is constructed, it is
     * automatically stored within leaf_Base.
     *
     * @param   string  $Id
     * @param   object  $Obj
     * @return  void
     */
    public function __construct($Id, $Obj)
    {
        if (array_key_exists($Id, self::$BaseObjects)==FALSE)
            self::$BaseObjects[$Id] = $Obj; 
    }

    /**
     * Returns a stored object.
     *
     * @param   string  $Id
     * @return  object|NULL
     */
	public function __get($Id)
	{
        return self::fetch($Id);
	}
    
    /**
     * Stores an object.
     *
     * @param   string  $Id
     * @param   object  $Obj
     * @return  void
     */
	public function __set($Id, $Obj)
	{
	    return;
	}
    
    /**
     * Returns an object.
     * 
     * This is the static version of magic method "__get"
     *
     * @param   string  $Id   
     * @return  object|NULL
     */
    public static function fetch($Id)
    {
        if (self::exists($Id))
            return self::$BaseObjects[$Id];
        else
            return NULL;
    }
    
    /**
     *  Checks is the requested object exists.
     *
     * @param   string  $Id
     * @return  boolean
     */
    public static function exists($Id)
    {
        return array_key_exists($Id, self::$BaseObjects);
    }
    
    /**
     * Prevents object-cloning.
     *
     * @return  void
     */
    private function __clone()
    {
    
    }
    
    /**
     * Returns a short description about the class.
     *
     * @return  string
     */
    abstract public function __toString();
    
}

