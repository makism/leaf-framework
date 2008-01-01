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
     * <br>
     * Supported options are:
     * <ol>
     *  <li><b>merge</b> <i>(boolean)</i>: Whether or not merge the currently
     *  passed variables with those that have been previously passed.<br>
     *  Defaults in <i>true</i>.</li>
     *  <li><b>expose</b> <i>(boolean)</i>: Request to make all the variables
     *  available in the View object visible to the current view file.<br>
     *  Defaults in <i>true</i>.</li>
     * </ol>
     *
     * @param   string  $view
     * @param   array   $data
     * @param   array   $opts
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
    public function render($view, array $data=NULL, array $opts=NULL)
    {
        // Number of the passed arguments.
        $s = sizeof($data);

        // View`s filename
        $name = NULL;

        // Application name.
        $app = NULL;

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

            // By default, the currently passed variables will be merge
            // with those already stacked.
            // This can be changed by passing:
            // "merge" => false
            // to the option array.
            if (!empty($data))
                if (!isset($opts['merge']) || $opts['merge']!=false)
                    $this->allVariables = array_merge($this->allVariables, $data);

            // Make all variables visible to the included View file.
            // It is possible to export only the current vars, ignoring
            // those at the View`s stack.
            if (!isset($opts['expose']) || $opts['expose']!=false) {
                if (!empty($this->allVariables)) {
                    foreach ($this->allVariables as $Idx => $Val) {
                        echo "<!-- exposing var \"{$Idx}\", contains \"{$Val}\" to \"{$this->currViewFile}\" -->\n";
                        ${$Idx} = $Val;
                    }            
                }
            }
                      
            if (!empty($data)) {
                foreach ($data as $Idx => $Val) {
                    echo "<!-- exporting var \"{$Idx}\", contains \"{$Val}\" to \"{$this->currViewFile}\" -->\n";
                    ${$Idx} = $Val;
                }
            }
            
            // Clear the local variables.
            unset($data, $app, $idx, $name, $s);

            
            require_once $this->currViewFile;
        }

    }

    public function __toString()
    {
        return __CLASS__ . " (Handles the Views of your application)";
    }

}
