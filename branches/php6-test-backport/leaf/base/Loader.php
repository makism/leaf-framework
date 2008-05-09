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
 * Handles the loading requests for resources like Libraries,Models,
 * Extensions and Plugins.
 * 
 * (This class is far from being labeled as completed in many ways. This means
 * that many changes will occur, possibly <b>breaking</b> internal compatibility.)
 * 
 * @package	    leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version     SVN: $Id$
 */
class leaf_Loader extends leaf_Base {
    
    const BASE_KEY = "Loader";
    
    
    /**
     *
     *
     * @var object leaf_Loader
     */
    protected static $instance = NULL;
     

    /**
     * List of all the loaded plugins.
     * 
     * @var array 
     */
    private $plugins = array();
    
    /**
     * List of all loaded libraries.
     * 
     * @var array
     */
    private $libraries = array();
    
    /**
     * List of all currently supported libraries.
     * 
     * @var array 
     */
    private $allLibraries = array(
        "Log"
    );
    
    /**
     * List of all loaded extensions.
     * 
     * @var array
     */
    private $extensions = array();
    

    /**
     *
     *
     * @return  void
     */
    public function __construct()
    {     
        parent::__construct(self::BASE_KEY, self::$instance);
        require_once LEAF_BASE . "base/helpers/Loader.php";      
    }
    
    /**
     *
     *
     * @return  object leaf_Loader
     */
    public static function getInstance()
    {
        if (self::$instance==NULL)
            self::$instance = new leaf_Loader();
    
        return self::$instance;
    }
	
    /**
     * Loads a "Core Library" class.
     * 
     * Core libraries, are these libraries that although are not
     * really needed to run the framework properly, they are bundled
     * with it, since they very useful...<br>
     * List of the libraries:
     * <ul>
     *  <li>Db (<i>Communicate with a database.</i>)</li>
     *  <li>Cache (<i>Cache data for faster access.</i>)</li>
     *  <li>Hash (<i>Create hashes for the specific input.</i>)</li>
     *  <li>Log (<i>Log errors that the framework may produce, or your own messages.</i>)</li>
     *  <li>Benchmark (<i>Benchmark specific parts of the internals, or your code.</i>)</li>
     *  <li>Unit (<i>Perform simple Unit Tests on your classes.</i>)</li> 
     * </ul>
     * 
     * @param   string  $libName
     * @param   array   $settings
     * @return  void
     * @todo
     * <ol>
     *  <li>It is given a second thought the possibility that <b>all</b> these
     *  libraries are moved outside the core package.</li>
     * </ol>
     */
    public function library($libName, array $settings=NULL)
    {        
        // Check if the the requested library is either
        // supported or already registered.
        if (in_array($libName, $this->allLibraries) &&
            $this->libraryLoaded($libName)==false) {
        	$leafName= "leaf_" . $libName;
        	$libFile = $libName . ".php";
    
            leaf_Registry::getInstance()->register(new $leafName($settings));
            
            $this->libraries[] = $libName;
        }
    }
    
    /**
     * Checks if the specified library is loaded.
     *
     * @param   string  $libName
     * @return  boolean
     */
    public function libraryLoaded($libName)
    {
        return in_array($libName, $this->libraries);
    }
    
    /**
     * Loads an "Extension" class.
     *
     * @param   string  $ext
     * @param   string  $namespace
     * @return  void
     */
	public function extension($ext, $namespace=NULL)
	{
	
	}
	
    /**
     * Loads a "Plugin" file.
     * 
     * "Plugin", is a common php script file that contains
     * a number of functions.<br>
     * It is most likely, that each plugin, will have a specific
     * "topic", Url-manipulating for example.<br>
     * Possible candidates as Plugins, are the todo-facade methods
     * for class {@link leaf_Request}.
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
    
    public function __toString()
    {
        return __CLASS__ . " (Loads libraries and plugins)";
    }

}

