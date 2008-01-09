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
 * Extensions and Plugins.
 * 
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 *  <li>Possible splitting into a second "Repository" class that will
 *  hold all the instancies.</li>
 * </ol>
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
     *     <li><b>bindName</b> <i>(string)</i>: the instance name (REQUIRED)</li>
     *     <li><b>application</b> <i>(string)</i>: source application</li>
     *     <li><b>global</b> <i>(boolean)</i>: restrict access to the model</li>
     *     <li><b>args</b> <i>(array)</i>: arguments passed to the contructor</li>
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
     *  <li>Make "bindName" setting optional, and use the class` name as the
     *  instance name.</li>
     * </ol>
     */
    public function model($modelName, array $settings=NULL)
    {
    	// Assume usage method #2
    	// That is, retrieving a Model instance.
    	if (!isset($settings)) {
    		if (array_key_exists($modelName, $this->models))
    		  return $this->models[$modelName];
    		else
    		  return NULL;
    		  
        // Fallback to usage method #1
        // That is, loading a new Model.
        // >> We demand that the property "bindName" is set,
        //    otherwise we ignore the loading. 
    	} else {
    		if (!empty($settings['bindName'])) {
    			// application base name
	    		$baseDir =
	    		  "applications/" .
	    		  $this->Request->getApplicationName() .
	    		  "/Model/";
	    		  
	    		// instance name
	    		$instanceName = $settings['bindName'];
	    		
	    		// model`s filename
	    		$modelFile = $baseDir . $modelName . ".php";
	    		
	    		// class name
	    		$modelClass = $modelName . "_Model";
	    		
	    		if (file_exists($modelFile) && is_readable($modelFile)) {
	    			// include model class
	    			require_once $modelFile;
	    			
	    			// instantiate and register model
	    			$instance = new $modelClass;
	    			if ($instance instanceof leaf_Model)
	    			    $this->models[$instanceName] = $instance;	
	    		}
	    		
    		} else {
    			return NULL;
    		}
    	}
    }
	
    /**
     * Loads a Core Library class.
     * 
     * Core libraries, are these libraries that although are not
     * really needed to run the framework properly, they are bundle
     * with it, since they very useful...
     * 
     * @param   string  $libName
     * @param   array   $libName
     * @return  void
     */
    public function library($libName, array $settings=NULL)
    {
    	
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
			//"applications/" . $app . "/View/" . $name . ".php";
			$fileName = "leaf/plugins/" . $plugin . ".php";
			if (file_exists($fileName) && is_readable($fileName)) {
				require_once $fileName;
				
				$this->plugins[] = $plugin;
			}
		}
	}

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

}

?>
