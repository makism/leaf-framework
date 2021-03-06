<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


class leaf_LocalLoader extends leaf_Common {

    /**
     *
     *
     * @var array
     */
    private $models = array();
    
    
    /**
     *
     *
     * @return  void
     */
    public function __construct($controllerName)
    {
        parent::__construct($controllerName);
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
            if (!empty($settings) && isset($settings['application'])) {
                $appName = $settings['application'];
            } else if ( ($pos=stripos($modelName, "/"))!==FALSE ) {
                $appName = substr($modelName, 0, $pos);
                $modelName = substr($modelName, $pos+1);
            } else {
                $appName = $this->Request->getApplicationName();
            }

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
    			$instance = new $modelClass (
                    $this->Request->getControllerName()
                );
    			
    			// bind name
    			$bindName = @constant("{$modelClass}::BIND_NAME");
    			
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

}

