<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @filesource
 */


/**
 * Includes all necesarry files related to leaf`s classes.
 *
 * We use the "magic" function __autoload in order
 * to have leaf`s classes loaded automatically.<br>
 * Also, {@link leaf_EndorsedManager Endorsed Manager} is
 * instantiated if needed.
 *
 * @link	http://www.php.net/manual/en/language.oop5.autoload.html
 * @see     leaf_EndorsedManager
 * @param	string $className
 * @return	void
 */
function __autoload($className)
{
	static $baseClasses;
#    static $hasInited;
#    static $enableEndorsementManager;
#    static $endorsementManager;

    /*
     * Determine if EndorsedManager is enabled.
     */
#    if ($hasInited) {
#        if (leaf_Registry::getInstance()->config['allow_endorsed']) 
#            $enableEndorsementManager = TRUE;
#        $hasInited=NULL;
#    }

    /*
     * If, EndorsedManager has been enabled, we
     * instantiate it.
     */
#    if ($endorsementManager==NULL && $enableEndorsementManager==TRUE) {
#        require_once LEAF_BASE . "core/EndorsementManager.php";
#        leaf_Registry::getInstance()->register(new leaf_EndorsementManager());
#        $endorsementManager = leaf_Registry::getInstance()->EndorsementMan;
#    }
	
    /*
     * Most of the leaf`s classes.
     */
    if ($baseClasses==NULL)
    	$baseClasses = array (
    	/** Base libraries             **/
            'leaf_Base'      => 'Base.php',
    		'leaf_Config'    => 'Config.php',
            'leaf_Dispatcher'=> 'Dispatcher.php',
            'leaf_Exception' => 'Exception.php',
            'leaf_Loader'    => 'Loader.php',
            'leaf_Locale'    => 'Locale.php',
            'leaf_Registry'  => 'Registry.php',
            'leaf_Router'    => 'Router.php',
        /** Request/Response            **/
            'leaf_Request'   => 'Request.php',
            'leaf_Response'  => 'Response.php',
    	/** MVC core libraries          **/
            'leaf_Controller'=> 'Controller.php',
            'leaf_Model'     => 'Model.php',
            'leaf_View'      => 'View.php',
        /** Collections libraries       **/
            'leaf_Collection'=> 'Collection.php',
            'leaf_Enumeration'=> 'collections/Enumeration.php',
            'leaf_Iterator' => 'collections/Iterator.php',
        /** Hooks libraries             **/
            'leaf_Hook'      => 'hook/Hook.php',
            'leaf_Hook_Conditional'=> 'hook/Hook_Conditional.php',
        /** Logs libraries              **/
#            'leaf_Log'       => 'log/Log.php',
#            'leaf_Logger'    => 'log/Logger.php',
        /** Database-related libraries  **/
#			'leaf_Db'        => 'db/Db.php',
    	/** Other core libraries        **/
#            'leaf_Benchmark' => 'Benchmark.php',
#            'leaf_Input'     => 'Input.php',
#            'leaf_Hash'      => 'Hash.php'
    	);

    /*
     * Check to dermine whether or not, the requested class
     * is part of leaf`s core.
     */
  	if (array_key_exists($className, $baseClasses)) {

        /*
         * We let the EndorsedManager to handle the external
         * classes that will overlap the internal ones.
         */
#        if ($enableEndorsementManager) {
#            if ($endorsementManager->isEndorsed($className))
#                $endorsementManager->loadEndorsedClass($className);
#            else
#                require_once LEAF_BASE
#                            . 'core/'
#                            . $baseClasses[$className];
#        } else {
          	require_once LEAF_BASE
                        . 'core/'
                        . $baseClasses[$className];
#        }
    }
    
    /*
     * If the class {@link leaf_Config} has been called,
     * we can access the configuration parameters and
     * determine if EndorsedManager is enabled.
     */
#    if ($className=="leaf_Config")
#        $hasInited = TRUE;
}
