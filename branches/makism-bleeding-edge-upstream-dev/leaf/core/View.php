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
 * Handles the "View" files.
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
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
     * @return  void
     * @todo
     * <ol>
     *  <li>When this method is called, the Output Buffer, will be also
     *  flushed and terminating. This will spawn the "include" method
     *  which will be similar except the Ob thingie.</li>
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

        	// Make the passed variables visible to the included
            // View file.
        	if (!empty($data))
        	   foreach ($data as $Idx => $Val)
        	       ${$Idx} = $Val;

            require_once $this->currViewFile;
        }

    }

    public function __toString()
    {
        return __CLASS__ . " (Handles the Views of your application)";
    }

}

?>
