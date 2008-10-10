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
     * List of all loaded extensions.
     * 
     * @var array
     */
    private $extensions = array();
    

    /**
     * Registers Loader.
     *
     * @return  void
     */
    public function __construct()
    {     
        parent::__construct("Loader", $this);
        require_once LEAF_BASE . "base/helpers/Loader.php";
		
		if ($this->Config['common_extensions_usage']==FALSE) {
			$this->extensions = array (
				"apps"	 => array(),
				"orphans"=> array()
			);
		}
    }
    
    /**
     * Loads an "Extension" class.
     * 
     * The loading of the extension classes is affected by the configuration
     * setting "common_extensions_usage" in the general.php settings.
     * When set to TRUE, every extension loaded will be common among the
     * running applications (also known as "orphan").
     * When set to FALSE, evey extension loaded will be available to the
     * application that has requested the specific extension.
     * 
     * An extension is considered to be orphan, when either the parameter
     * "declareOrphan" is set to TRUE (no matter the value of the setting
     * "common_extensions_usage"), or when loaded using the helper function
     * "use_extension()". 
     *
     * @param   string		$ext
     * @param   boolean     $declareOrphan
     * @return  void|object
     */
	public function extension($ext, $declareOrphan=FALSE)
	{
		// exploade the fully-qualified class name
	    $fq = explode(".", $ext);
		
		// prepare the directory in which the class resides
	    $classFile = LEAF_BASE . 'extensions/';
		
		// attach all the parts in the directory
		for ($i=0; $i<sizeof($fq)-1; $i++) {
			$classFile .= $fq[$i] . "/";
		}
		
		// base directory
		$classBase = (sizeof($fq)>=3) ? $classFile : NULL;
		
		// chop the classname
		$className = $fq[sizeof($fq)-1];
		
		// finalize the class`s filename
		$classFile .= $className . ".php";
		
		$readyToLoad = FALSE;
		
		/*
		 * Orphan extensions handling.
		 * 
		 * This block, ensures that extensions can be loaded
		 * even before a controller is running.
		 */
		if (
			($this->Config['common_extensions_usage']==FALSE && $declareOrphan==TRUE) ||
			($this->Config['common_extensions_usage']==TRUE && $declareOrphan==TRUE) ||
			($this->Dispatcher==NULL || $this->Dispatcher->getCurrentController()==NULL)
			)
		{
			if ($this->extensionLoaded($ext)==FALSE) {
				$this->extensions['orphans'][] = $ext;
				require_once $classFile;
			    $instance = new $className($ext, $classBase);
				
				if ($instance  instanceof leaf_Extension) {
					//if ($this->extensionDependancies($instance)) {
					    $instance->parseConfig();
					    $instance->init();
						parent::__set($className, $instance);
						return $instance;
					//}
				} else {
					unset($instance);
				}
			} else {
				return parent::__get($className);
			}
		}

	    if ($this->extensionLoaded($ext)==FALSE) {
			if (file_exists($classFile) && is_readable($classFile)) {
				if ($this->Config['common_extensions_usage']==TRUE) {
					$this->extensions[] = $ext;
				} else {
		            $this->extensions['apps'][
						$this->Dispatcher->getCurrentController()
					][] = $ext;
				}
				
	            require_once $classFile;
				
				$readyToLoad = TRUE;
			}
	    } else {
			if ($this->Config['common_extensions_usage']==TRUE) {
				return parent::__get($className);
			} else {
				$readyToLoad = TRUE;
			}
		}
		
		if ($readyToLoad===TRUE) {
		    $instance = new $className ($ext, $classBase);
			
			if ($instance instanceof leaf_Extension) {
			    $instance->parseConfig();
			    $instance->init();
			} else {
				//
			}
			
			/*if ($fq[0]=="leaf") {
				$className = @constant("{$className}::BIND_NAME");
			}*/
			
			if ($this->Config['common_extensions_usage']==FALSE) {
				// assign the library`s instance with the current
				// running controller
				leaf_Registry::getInstance(
					$this->Dispatcher->getCurrentController()
				)->register($className, $instance);
			} else {
				parent::__set($className, $instance);
			}
			
			return $instance;
		}
	    
	}
	
	/**
	 * Overloaded method used to load extensions using
	 * dynamic method naming.
	 *
	 * For example, using the "extension" method we would write:
	 * <code>
	 *  $this->Loader->extension("leaf.tmp.TestLib");
	 * </code>
	 * While, using the overloaded method, we can write:
	 * <code>
	 *  $this->Loader->extensionInTmpFromLeaf("TestLib");
	 * </code>
	 * Underneath, the "extension" method is called.
	 *
	 * @param   string $method
	 * @param   array  $arguments
	 * @return  void
	 */
	public function __call($method, $arguments)
	{
		$fq = NULL;
		$matchOneLevel = "^extensionFrom(?P<dir>[a-z0-9]*)";
		$matchTwoLevel = "^extensionIn(?P<subdir>[a-z0-9]*)From(?P<dir>[a-z0-9]*)";
		
		if ($matchTwo = preg_match("@" . $matchTwoLevel . "@i", $method, $hits)) {
			$fq = strtolower("{$hits['dir']}.{$hits['subdir']}.") . $arguments[0];
			
		} else if ($matchOne = preg_match("@" . $matchOneLevel . "@i", $method, $hits)) {
			$fq = strtolower($hits['dir']) . "." . $arguments[0];
		}
		
		if ($fq!=NULL)
			return $this->extension($fq);
		else
			throw new Exception("Error loading extension.", 1000);
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
     * Checks if the specified extension is loaded.
     * 
     * This method, just like "extension()", is affected by the configuration
     * setting "common_extensions_usage".
     *
     * @param   string  $fqExtName
     * @return  boolean
     */
    public function extensionLoaded($fqExtName)
    {
		if ($this->Config['common_extensions_usage']==TRUE) {
			return in_array($fqExtName, $this->extensions);
		} else {
			if (in_array($fqExtName, $this->extensions['orphans'])) {
				return TRUE;
			} else if (
				$this->Dispatcher!=NULL && 
				in_array (
					$this->Dispatcher->getCurrentController(),
					$this->extensions['apps']
				)
			) {
		        return TRUE;
			} else {
				return FALSE;
			}
		}
    }
	
	/**
	 *
	 *
	 * @param	object leaf_Extension	$object
	 * @return	boolean
	 */
/*	 
	private function extensionDependancies($obj)
	{
		if ($obj->php_dependancies()==NULL)
			return TRUE;
		
		foreach ($obj->php_dependancies() as $mod) {
			if ($mod!="")
				if (!extension_loaded($mod))
					throw new leaf_Exception("PHP extension not loaded \"{$mod}\"", 6000);
		}
		
		return TRUE;
	}
*/
    
    /**
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . " (Loads extensions and plugins)";
    }

}

