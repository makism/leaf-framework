<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Holds up all the Core instances that are related with a specific application.
 * 
 * This class, implements the Multiton design pattern.
 *
 * @package	    leaf
 * @subpackage	core
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version 	SVN: $Id$
 * @see         leaf_Base
 */
class leaf_Registry {

	/**
     * All currently registered classes.
     *
     * @var array
     */
	private static $instances = NULL;

    /**
     * The registered objects that holds the current Registry object.
     *
     * @var array
     */
    private $registry = array();
    
    
    /**
     * Prevents external instantiation. Used by the Singleton design pattern.
     *
     * @return  void
     */
    private function __construct()
    {
        return;
    }
    
    /**
     * Returns the Registry object that is associated with a specific
     * application, or creates a new Registry.
     *
     * @param   string  $key    The associated application name
     * @return  object  leaf_Registry   Registry instance
     */
    public static function getInstance($Key)
    {    
        if (self::$instances==NULL)
            self::$instances = array();
     
        $instance = NULL;	
        
        if (isset(self::$instances[$Key]))
            $instance = self::$instances[$Key];
        
        if ($instance==NULL) {
            $instance = new leaf_Registry();
            self::$instances[$Key] = $instance;
        }
        
        return $instance;
    }
	
	/**
	 * Returns all registered Controllers` names.
	 * 
	 * @return	array
	 */
	public static function getInstanceKeys()
	{
		return self::$instances;
	}
	
	/**
	 * Return the request object, by refering to it`s instance name.
     *
	 * @param	string	$Id
	 * @return	object|NULL
     */
	public function __get($Id)
	{
        return $this->registry[$Id];
	}
	
	/**
	 * Registers the requested instance using the designated key.
	 *
	 * @param	string	$Id
	 * @param	object	$Obj
	 * @return	void
	 */
	public function register($Id, $Obj)
    {
        $this->registry[$Id] = $Obj;
    }

    /**
     * Returns true if the requested object is available in the
     * current Registry object.
     *
     * @return  boolean
     */
    public function registered($Id)
    {
        return array_key_exists($Id, $this->registry);
    }
    
}

