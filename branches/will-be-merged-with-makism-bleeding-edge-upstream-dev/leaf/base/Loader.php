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
 * Handles the loading requests for resources like Libraries,Models,
 * Extensions and Plugins.
 * 
 * (This class is far from being labeled as completed in many ways. This means
 * that many changes will occur, possibly <b>breaking</b> internal compatibility.)
 * 
 * @package		leaf
 * @subpackage	base
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
class leaf_Loader extends leaf_Base {

    const LEAF_REG_KEY = "Load";
    
    const LEAF_CLASS_ID = "LEAF_LOADER-1_0_dev";

    /**
     * List of all the loaded plugins.
     * 
     * @var array 
     */
    private $plugins = array();
    
    /**
     * List of Models` instances.
     * 
     * @var array
     */
    private $models = array();
    
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
        parent::__construct(self::LEAF_REG_KEY);
        
        require_once LEAF_BASE . "core/helpers/Loader.php";      
    }
    
    /**
     * Loads a "Model" using the specified settings.
     *
     * Method usage
     * <ul>
     *  <li>
     *   <i>Model loading</i><br>
     *   This means, that you pass to the method, the Model`s name you
     *   desire to load, and you specify any settings if you would like.<br>
     *   The available settings are:
     *    <ol>
     *     <li><b>bindName</b> <i>(string)</i>: the instance name.</li>
     *     <li><b>application</b> <i>(string)</i>: source application.</li>
     *     <li><b>global</b> <i>(boolean)</i>: restrict access to the model.</li>
     *     <li><b>args</b> <i>(array)</i>: arguments passed to the contructor.</li>
     *    </ol>
     *  </li>
     *  <li>
     *   <i>Model referencing</i><br>
     *   This means, that you retrieve the instance of the Model you
     *   requested. The settings passed, are ignored.
     *  </li>
     * </ul>
     *
     * @param   string  $modelName
     * @param   array   $settings
     * @return  object|NULL
     * @todo
     * <ol>
     *  <li>Extend support for settings.</li>
     * </ol>
     */
    public function model($modelName, array $settings=NULL)
    {
    	// Assume usage method #2
    	// That is, retrieving a Model instance.
    	if ($this->modelLoaded($modelName)) {
    		  return $this->models[$modelName];
    		  
        // Fallback to usage method #1
        // That is, loading a new Model.
    	} else {
			// application base name
            $appName = (!empty($settings) && isset($settings['application']))
                        ? $settings['application']
                        : $this->Request->getApplicationName();
            
    		$baseDir =
    		  "applications/" .
    		  $appName .
    		  "/Model/";
    		  
            // model`s filename
            $modelFile = $baseDir . $modelName . ".php";
            
            // class name
            $modelClass = $modelName . "_Model";
    		
    		if (file_exists($modelFile) && is_readable($modelFile)) {
    			// include model class
    			require_once $modelFile;
    			    			
    			// instantiate and register model
    			$instance = new $modelClass;
    			
    			// bind name
    			$bindName = @constant("{$modelClass}::MODEL_ALIAS");
    			
    			// Give the "bindName" parameter given in the
    			// "settings" array higher priority, thus
    			// overlapping the default bind name.
    			if (!empty($settings['bindName'])) {
    			    $bindName = $settings['bindName'];
    			}
                
    			if ($bindName==NULL) {
    			    return NULL;
    			}
    			
    			if ($instance instanceof leaf_Model)
    			    $this->models[$bindName] = $instance;	
    		}

    	}
    }
    
    /**
     * Checks if the specified model is loaded.
     * 
     * @param   string  $modelName
     * @return  boolean
     */
    public function modelLoaded($modelName)
    {
        return array_key_exists($modelName, $this->models);
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
        return __CLASS__ . " (Enables you to load Models/Libraries etc...)";
    }

}
