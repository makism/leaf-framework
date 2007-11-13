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

    const LEAF_REG_KEY = "view";
    
    const LEAF_CLASS_ID = "LEAF_VIEW-1_0_dev";


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
     * Includes and renders a view file.
     * 
     * View files, are common php script files.
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
     *  <li>It is an obvious bug that is the user declares a variable
     *  with the "viewFile", this will result in overlapping the local
     *  variable that holds the file in which the view is located.</i>
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
        	$app = $this->request->getApplicationName();
        }
        
        // Create the file final name...
        $viewFile = "applications/" . $app . "/View/" . $name . ".php";
                
        if (file_exists($viewFile) && is_readable($viewFile)) {
        	// Make the passed variables visible to the included
            // View file.
        	if (!empty($data))
        	   foreach ($data as $Idx => $Val)
        	       ${$Idx} = $Val;

            require_once $viewFile;
        }
        
    }

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

}

?>
