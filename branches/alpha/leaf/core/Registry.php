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
 * Registry class that lists most of the instantiated internal classes.
 *
 * This class implements the {@link http://www.phppatterns.com/docs/design/the_registry Registry design pattern}.<br>
 * When an internal class is instantiated, registers itself
 * in this class.<br>
 * This way, we provide a fast and easy way for the internal
 * class to "communicate" each other.
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		$Id$
 * @see         leaf_Base
 * @todo
 * <ol>
 *  <li>Thinking about listing all possible entries with their
 *  types - so there are some sanity checks...?</li>
 * </ol>
 */
final class leaf_Registry {

	/**
     * All currently registered classes.
     *
     * @var array
     */
	private $registered = array();
	
    /**
     * The unique instance of this class.
     *
     * This class implements the {@link http://www.phppatterns.com/docs/design/singleton_pattern Singleton design pattern}.<br>
     * That is, there can be only one instance of this class.
     *
     * @var object leaf_Registry
     */
    private static $instance = NULL;
	

	/**
	 * Declared private in favor of the Singleton pattern.
     *
	 * @return void
	 */
	private function __construct()
	{
		
	}
	
	/**
	 * If needed, instantiates an object of this class.
     *
	 * @return  void
	 */
	public static function instance()
	{
		if (self::$instance==NULL)
			self::$instance = new leaf_Registry();
	}

    /**
     * Returns the instance of this class.
     *
     * @return  object leaf_Registry
     */
    public static function getInstance()
    {
        self::instance();
        return self::$instance;
    }
	
	/**
	 * Return the request object, by refering to it`s instance name.
     *
	 * @param	string	$key
	 * @return	mixed
     */
	public function __get($key)
	{
		if ($this->isRegistered($key))
			return $this->registered[$key];
		else 
            return NULL;
	}
	
	/**
	 * Registers the requested instance using the designated key.
	 *
	 * @param	string	$key
	 * @param	object	$obj
	 * @return	void
	 */
	private function __set($key, $obj)
	{
		if ($this->isRegistered($key)==FALSE)
			$this->registered[$key] = $obj;
	}
	
	/**
	 * Registers an object.
     *
     * When an object is passed to register, we suppose
     * the constant LEAF_REG_KEY, exists and we use it
     * as a reference key.
     *
	 * @param	object	$obj
	 * @return	void
     * @todo
     * <ol>
     *  <li>Perform some checks to find out if the object passed,
     *  has declared the constant LEAF_REG_KEY, and possible
     *  examine further it`s behaviour.</li>
     * </ol>
	 */	
	public function register($obj)
    {
        $className  = get_class($obj);
        $registryKey= constant("{$className}::LEAF_REG_KEY");
                
		$this->__set($registryKey, $obj);
	}

    /**
     * Removes a key from the registry.
     *
     * @param   string  $class
     * @return  void
     * @todo
     * <ol>
     *  <li>Implement.</li>
     * </ol>
     */
    public function unregister($class)
    {
        return;
    }

	/**
     * Checks for the existence of the requested key.
	 *
	 * @param	string	$key
	 * @return	boolean
	 */
	public function isRegistered($key)
	{
		if (array_key_exists($key, $this->registered))
			return TRUE;
		else
			return FALSE;
	}

    /**
     * Returns an associative array with all the "general"
     * configuration parameters.
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->registered;
    }

}

?>
