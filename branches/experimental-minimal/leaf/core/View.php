<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf\Core;


/**
 * Represents the request for variable merging.
 */
define('VIEW_MERGE', 1);

/**
 * Represents the request for variable exposure.
 */
define('VIEW_EXPOSE', 2);


/**
 * Handles the "View" files.
 *
 * @package	    leaf
 * @subpackage	core
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version	    SVN: $Id$
 */
final class View extends Common {
    
    /**
     * Default option parameters for all View files.
     *
     * @var array
     */
    private $options = array (
        "merge" => false,
        "expose"=> false,
        "verbose"=> false
    );
	
    /**
     * Current View filename.
     *
     * @var string
     */
    private $currViewFile = NULL;

    /**
     * List of all the View files.
     *
     * @var array
     */
    private $viewFileList = array();

    /**
     * List of all variables that will be become visible
     * to the Views.
     *
     * @var array
     */
    private $allVariables = array();

    
    /**
     * Associates with the specified controller.
     *
     * @return  void
     */
    public function __construct($controllerName)
    {
        parent::__construct($controllerName);
    }

    /**
     * Includes a dynamic view file.
     *
     * View files, are common php script files. You may
     * pass an associative array with the variables you want to
     * expose to the view files.<br>
     * Example:<br>
     * In your controller you write something like this
     * <code>
     *  $data = array ("title" => "Homepage");
     *  $this->view->render("somefile", $data);
     * </code>
     * While, in your view file you have:
     * <code>
     *  echo $title;
     * </code>
     * <br/>
     * 
     * The arguments that can be passed are:
     * <ul>
     *  <li>view file (string)</li>
     *  <li>data (associative array)</li>
     *  <li>VIEW_MERGE (constant)</li>
     *  <li>VIEW_EXPOSE (constant)</li>
     * </ul>
     * You can use any combination of the above.
     * 
     * Let`s comment "VIEW_MERGE" and "VIEW_EXPOSE".
     * "VIEW_MERGE" is meaningful only when you pass data. The data passed
     * are stored internally in the View class. For example:
     * <code>$this->View->render("viewFile", array("age"=>24,"name"=>"makism"), VIEW_MERGE);
     * "VIEW_EXPOSE", when used, all internally stored data become visible
     * to the view file.  For example:
     * <code>$this->View->render("viewFile", VIEW_EXPOSE);
     * Of course, you can even say this:
     * <code>$this->View->render("viewFile", array("age"=>99,"name"=>"Neo"), VIEW_MERGE, VIEW_EXPOSE);
     * 
     * Got it?
     * 
     *
     * @return  void
     */
    public function render()
    {
		$view = func_get_arg(0);
		
		// data
		$data = NULL;
        
        // View`s filename
        $name = NULL;
        
        // Application name.
        $app = NULL;
		
        // Total number of arguments passed to the function.
        $argsTotal = func_num_args();
        
        if ($argsTotal>=2) {
            $args = func_get_args();
			
			if (is_array($args[1]))
				$data = $args[1];
		}
		
		
        // Number of the passed data variables.
        $s = sizeof($data);
        
        // Check to determine whether the requested View file
        // is stored in external Application.
        $idx = strpos($view, "/");
        if ($idx!==false) {
            $app = substr($view, 0, $idx);
            $name= substr($view, $idx+1);
        } else {
            $name= $view;
        }
        
        // If no application name is given, or
        // "/" is found at the beginning of the
        // string, assign the current application`s
        // name.
        if ($app=="/" || $app==NULL) {
            $app = $this->Request->getApplicationName();
        }
        
        // Create the file final name...
        $this->currViewFile = "applications/" . $app . "/View/" . $name . ".php";
        
        if (file_exists($this->currViewFile) &&
            is_readable($this->currViewFile))
        {
            $this->viewFileList[] = $this->currViewFile;
            
            // Request to merge the current varialbes with those
            // previously passed and exist within the Views` stack.
            if (!empty($data) && $argsTotal>2) {
                if (in_array(VIEW_MERGE, $args)) {
                    $this->allVariables = array_merge($this->allVariables, $data);
                }
            }
            
            // Make all variables visible to the included View file.
            // It is possible to export only the current vars, ignoring
            // those at the View`s stack.
            if ($argsTotal>=2) {
                if (in_array(VIEW_EXPOSE, $args) && !empty($this->allVariables)) {
                    foreach ($this->allVariables as $Idx => $Val) {
                    
                        if ($this->options['verbose']) {
                            echo
                                "<!-- "
                                ."exposing var \"{$Idx}\", "
                                ."contains \"{$Val}\" to \"{$this->currViewFile}\""
                                ."-->\n";
                        }
                        
                        ${$Idx} = $Val;
                    }
                }
            }
            
            if (!empty($data)) {
                foreach ($data as $Idx => $Val) {
                
                    if ($this->options['verbose']) {
                        echo
                            "<!-- "
                            ."exposing var \"{$Idx}\", "
                            ."contains \"{$Val}\" to \"{$this->currViewFile}\""
                            ."-->\n";
                    }
                    
                    ${$Idx} = $Val;
                }
            }
            
            // Clear the local variables.
            unset($data, $app, $idx, $name, $s);
            
            require_once $this->currViewFile;
        }
        
    }
    
    /**
     * 
     * 
     * @return  void
     */
    public function template()
    {
        //will require a simple cache extension or something ;-)
        $args = func_get_args();
        ob_start();
        call_user_func_array(array($this, "render"), $args);
        $data = ob_get_clean();
        var_dump ($data);
    }
    
    /**
     * Includes a static view file, usually an html file.
     *
     * @param   string  $view
     * @return  void
     */
    public function view($view)
    {
        $name = NULL;
        
        $app = NULL;
        
        $idx = strpos($view, "/");
        if ($idx!==false) {
            $app = substr($view, 0, $idx);
            $name= substr($view, $idx+1);
        } else {
            $name= $view;
        }

        if ($app=="/" || $app==NULL) {
            $app = $this->Request->getApplicationName();
        }
        
        $this->currViewFile = "applications/" . $app . "/View/" . $name;
        
        if (file_exists($this->currViewFile) &&
            is_readable($this->currViewFile))
        {
            $this->viewFileList[] = $this->currViewFile;
            require_once $this->currViewFile;
        }
    }
    
    /**
     * Changes an "option" parameter.
     *
     * @param   string  $Option
     * @param   mixed   $Value
     * @return  void
     */
    public function set($Option, $Value)
    {
        if (array_key_exists($Option, $this->options))
            $this->options[$Value] = $Option;
    }

}


