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
 * Handles the loading requests for resources like the Models,
 * Extensions, Plugins, Libraries etc.
 * 
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 * </ol>
 */
class leaf_Loader extends leaf_Base {

    const LEAF_REG_KEY = "load";
    
    const LEAF_CLASS_ID = "LEAF_LOADER-1_0_dev";

    /**
     * List of all the loaded plugins
     * 
     * @var array 
     */
    private $plugins = array();
    
    /*
     * List of "black-listed" plugins.
     * 
     * These plugins are found to have some problems
     * and cannot be loaded.
     *  
     * @var array
     */
    private $pluginsBlacklist = array();
    

    /**
     *
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }

    /**
     *
     *
     * @param   string  $modelName
     * @param   array   $opts
     * @return  void
     */
    public function model($modelName, array $opts=NULL)
    {
    }

    /**
     *
     *
     * @param   string  $name
     * @return  void
     */
	public function library($name)
	{
		
	}
	
    /**
     *
     *
     * @param   string  $ext
     * @param   string  $namespace
     * @return  void
     */
	public function extension($ext, $namespace=NULL)
	{
	
	}

    /**
     *
     *
     * @param   string  $class
     * @return  void
     */
    public function endorsed($class)
    {

    }
	
    /**
     * Loads a "plugin".
     * 
     * "Plugin", is a common php script file that contains
     * a number of functions.<br>
     * It is most likely, that each plugin, will have a specific
     * "topic".
     * 
     * @param   string  $plugin
     * @return  void
     */
	public function plugin($plugin)
	{
		if (!in_array($plugin, $this->plugins)) {
			//"applications/" . $app . "/View/" . $name . ".php";
			$fileName = "leaf/plugins/" . $plugin . ".php";
			if (file_exists($fileName) && is_readable($fileName)) {
				require_once $fileName;
				
				$this->plugins[] = $plugin;
			} else {
				// add to "blacklist"
				$this->pluginsBlacklist[] = $plugin;
			}
		}
	}

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }
}

?>
