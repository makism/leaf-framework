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
 * Handles the loading requests for resources like Libraries,Models,
 * Extensions and Plugins.
 * 
 * (This class is far from being labeled as completed in many ways. This means
 * that many changes will occur, possibly <b>breaking</b> internal compatibility.)
 * 
 * @package	    leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
class Loader extends Base {
	

    /**
     * List of all the loaded plugins.
     * 
     * @var array 
     */
    private $plugins = array();
    

    /**
     * Registers Loader.
     *
     * @return  void
     */
    public function __construct()
    {     
        parent::__construct("Loader", $this);
        require_once LEAF_BASE . "base/helpers/Loader.php";
    }
 
    /**
     * Loads a "Plugin" file.
     * 
     * "Plugin", is a common php script file that contains
     * a number of functions.
     * 
     * @param   string  $plugin
     * @return  void
     */
	public function plugin($plugin)
	{
		if (!in_array($plugin, $this->plugins)) {
			$fileName = "leaf/plugins/" . $plugin . ".php";
			if (file_exists($fileName) && is_readable($fileName)) {
				require_once $fileName;
				
				$this->plugins[] = $plugin;
			}
		}
	}
	
	/**
	 * Checks if the specified plugin is loaded.
	 *
	 * @return boolean
	 */
	public function pluginLoaded($plugin)
	{
	    return in_array($plugin, $this->plugins);
	}
    
    /**
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . " (Loads extensions and plugins)";
    }

}

