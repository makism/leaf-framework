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
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
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
     *
     *
     * @var array
     */
    private $registry = array();
    
    
    /**
     *
     *
     * @return  void
     */
    private function __construct()
    {
        return;
    }
    
    /**
     *
     *
     * @param   string  $key
     * @return  object leaf_Registry
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

}
