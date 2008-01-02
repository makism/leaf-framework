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
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @todo
 * <ol>
 *  <li>Add support for Output Buffer.</li>
 * </ol>
 */
final class leaf_View extends leaf_Base {

    const LEAF_REG_KEY = "View";

    const LEAF_CLASS_ID = "LEAF_VIEW-1_0_dev";

    
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
     * Instantiates the super class.
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }

    /**
     * Includes a view file.
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
     *
     * @param   string  $view
     * @param   array   $data
     * @param   integer $opts1
     * @param   integer $opts2
     * @param   integer $opts...
     * @return  void
     * @todo
     * <ol>
     *  <li>Flush and terminate the Output Buffer after this method returns.</li>
     *  <li>Maybe this method and "include", will be implemeneted inside
     *  the overload method "__call".</li>
     *  <li>Create some "sanity" checks to run against the view name
     *  that is requested.</li>
     * </ol>
     */
    public function render($view, array $data=NULL)
    {
        // Number of the passed arguments.
        $s = sizeof($data);
        
        // View`s filename
        $name = NULL;
        
        // Application name.
        $app = NULL;
        
        // Total number of arguments passed to the function.
        $argsTotal = func_num_args();
        
        if ($argsTotal>2)
            $args = func_get_args();
        
        
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
            if ($argsTotal>2) {
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

    public function __toString()
    {
        return __CLASS__ . " (Handles the Views of your application)";
    }

}
