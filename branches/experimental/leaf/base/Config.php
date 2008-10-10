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
use leaf::Base::Base;


/**
 * Provides access to the configuration files.
 *
 * This class encapsulates all the configuration files.<br>
 * The parameters that are read from the general.php file, are
 * accessible as array offsets.<br>
 * Example:<br>
 * <code>
 *  $conf = new leaf_Config();
 *  echo $conf['base_uri'];
 * </code>
 *
 * This behaviour is succeeded by implementing the {@link http://www.php.net/~helly/php/ext/spl/interfaceArrayAccess.html ArrayAccess}
 * interface.<br>
 *
 * The other paremeters, are accessed by using the method
 * getByHashKey(configFileName). This method returns an array with
 * all the related configuration parameters.<br>

 *
 * This design was selected because the "general" properties are the
 * most commonly used, thus it is wise to provide a fast-access
 * method.<br>
 * Also, we could have used the "magic" methods "__call" and "__set",
 * but they are declared as "final" in the parent class.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
final class Config extends Base implements ArrayAccess {

    const BASE_KEY = "Config";

    
	/**
     * All configuration parameters will be stored in this array.
	 *
	 * @var array
	 */
	private $options = array();

    /**
     * All configuration parameters are stored in this array,
     * using their parent configuration file as index.
     *
     * @var array
     */
    private $optionsTable= array();

	/**
     * Registers Config, and loads all the configuration settings in an internal array.
	 *
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct(self::BASE_KEY, $this);
        
		require_once LEAF_BASE . 'etc/general.php';
		require_once LEAF_BASE . 'etc/error.php';
		require_once LEAF_BASE . 'etc/autoload.php';
		require_once LEAF_BASE . 'etc/hooks.php';
        require_once LEAF_BASE . 'etc/endorsed.php';
        require_once LEAF_BASE . 'etc/route.php';
        
        $this->optionsTable['general'] = $general;
        $this->optionsTable['autoload']= $autoload;
        $this->optionsTable['endorsed']= $endorsed;
        $this->optionsTable['hooks']   = $hooks;
        $this->optionsTable['route']   = $route;
        $this->optionsTable['error']   = $error;
        
        $this->options = $general;
		
    	unset($GLOBALS);
    }
    
    /**
     * Returns all parameters related with the specified key.
     *
     * @param   string  $key
     * @return  array|NULL
     */
    public function fetchArray($key)
    {
        if (array_key_exists($key, $this->optionsTable))
            return $this->optionsTable[$key];
        else
            return NULL;
    }

    /**
     * Overload method, to provide fast access to a group of parameters.
     * 
     * This is accompliced, by defining virtual methods prefixed with
     * "fetch" and followed by the name of group paramaters.
     * Even an array offset (setting name) can be used, to return the specific
     * one, otherwise the entire array will be returned.
     * For example:<br>
     * <code>
     *  $conf = new leaf_Config();
     *  $generalParamaters = $conf->fetchGeneral("locale");
     * </code>
     * In the above example, we request the value of the configuration
     * option "locale" from the array of options "general".
     *
     * @param   string  $method
     * @param   array   $args
     * @return  array|string|NULL
     */
    public function __call($method, $args)
    {
        if (preg_match("@^fetch(?P<opts>[A-Z]{1}.+)@", $method, $hits)) {
            if (!empty($hits) && isset($hits['opts'])) {
                $array = strtolower($hits['opts']);

                if (array_key_exists($array,$this->optionsTable)) {
                    if (!empty($args)) {
                        $param = $args[0];

                        if (array_key_exists($param,$this->optionsTable[$array]))
                            return $this->optionsTable[$array][$param];
                    } else {
                        return $this->fetchArray($array);
                    }
                }
            }
        }

        return NULL;
    }
    
    /**
     * Returns an array containing the general configuration options.
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->options;
    }

	/**
	 * Checks if the request parameter-name exists.
     *
	 * @param	string	$offset
	 * @return	boolean
	 */
	public function offsetExists($offset)
	{
		if (array_key_exists($offset, $this->options))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Returns the value of the specified parameter.
     *
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function offsetGet($offset)
	{
		return $this->options[$offset];
	}

	/**
     * Sets a value in the specific parameter.
     *
	 * @param	string	$offset
	 * @param	mixed	$value
	 * @return	void
	 */
	public function offsetSet($offset, $value)
	{
        //$this->options[$offset] = $value;
	}

	/**
     * Unsets a parameter.
     *
     * Unsets a parameter while the script is executed, that
     * is, it doesn`t mean it updates the configuration file
     * itself.
	 *
	 * @param	string	$offset
	 * @return	void
	 */
	public function offsetUnset($offset)
	{
        unset($this->options[$offset]);
	}

    /**
     * 
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . " (Provides read access to the config files)";
    }
    
}

