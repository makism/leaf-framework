<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright   Copyright (c) 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
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
    static $hasInited;
    static $enableEndorsementManager;
    static $endorsementManager;

    /*
     * Determine if EndorsedManager is enabled.
     */
    if ($hasInited) {
        if (leaf_Registry::getInstance()->config['allow_endorsed']=="Yes") 
            $enableEndorsementManager = TRUE;
        $hasInited=NULL;
    }

    /*
     * If, EndorsedManager has been enabled, we
     * instantiate it.
     */
    if ($endorsementManager==NULL && $enableEndorsementManager==TRUE) {
        require_once LEAF_BASE . "core/EndorsementManager.php";
        leaf_Registry::getInstance()->register(new leaf_EndorsementManager());
        $endorsementManager = leaf_Registry::getInstance()->endorse_man;
    }
	
    /*
     * Most of the leaf`s classes.
     */
    if ($baseClasses==NULL)
    	$baseClasses = array (
            'leaf_Base'      => 'Base.php',
            'leaf_Benchmark' => 'Benchmark.php',
    		'leaf_Config'    => 'Config.php',
            'leaf_Controller'=> 'Controller.php',
            'leaf_Debug'     => 'Debug.php',
            'leaf_Dispatcher'=> 'Dispatcher.php',
            'leaf_Exception' => 'Exception.php',
            'leaf_Hash'      => 'Hash.php',
            'leaf_Hook'      => 'hook/Hook.php',
            'leaf_Hook_Conditional'=> 'hook/Hook_Conditional.php',
            'leaf_Loader'    => 'Loader.php',
            'leaf_Locale'    => 'Locale.php',
            'leaf_Log'       => 'log/Log.php',
            'leaf_Logger'    => 'log/Logger.php',
            'leaf_Model'     => 'Model.php',
            'leaf_Registry'  => 'Registry.php',
            'leaf_Request'   => 'Request.php',
            'leaf_Response'  => 'Response.php',
            'leaf_Router'    => 'Router.php',
            'leaf_View'      => 'View.php'
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
        if ($enableEndorsementManager) {
            if ($endorsementManager->isEndorsed($className))
                $endorsementManager->loadEndorsedClass($className);
            else
                require_once LEAF_BASE
                            . 'core/'
                            . $baseClasses[$className];
        } else {
          	require_once LEAF_BASE
                        . 'core/'
                        . $baseClasses[$className];
        }
    }
    
    /*
     * If the class {@link leaf_Config} has been called,
     * we can access the configuration parameters and
     * determine if EndorsedManager is enabled.
     */
    if ($className=="leaf_Config")
        $hasInited = TRUE;
}

/**
 * Terminates the execution of the framework.
 *
 * @return  void
 */
function frameworkForceTerminate()
{
    showHtmlMessage("Forced Termination", NULL, TRUE);
}

/**
 * Performs some basic tests to check whether
 * the framework is usable or not.
 * 
 * @param	boolean	$checkAll
 * @return	void
 */
function frameworkSanityCheck($checkAll=false)
{
    $msg = array();

    if (extension_loaded('spl')==FALSE) {
        $msg[] = "SPL functions are disabled.";
    }
    
    /*
     * LEAF_REL_STATUS
     */
    if (!defined('LEAF_REL_STATUS'))
        $msg[] = "No releasing status information found -"
                ."Missing \"LEAF_REL_STATUS\" declaration.\n";

    /*
     * LEAF_WORKING_DIR
     */
    if (!defined('LEAF_WORKING_DIR')) {
        $msg[] = "No Working directory is defined - "
                ."Missing \"LEAF_WORKING_DIR\" declaration.\n";
    } else {
        if (!is_readable(LEAF_WORKING_DIR)) {
            $msg[] = "Working directory is NOT readable.\n";
        } else {
            if (is_writeable(LEAF_WORKING_DIR)) {
                $msg[] = "Working directory IS writeable."
                        ."Security issues arise.\n";
            }
        }
    }

    /*
     * LEAF_BASE
     */
    if (!defined('LEAF_BASE')) {
        $msg[] = "No leaf Base directory is defined - "
                ."Missing \"LEAF_BASE\" declaration.\n";
    } else {
        if (!file_exists(LEAF_BASE)) {
            $msg[] = "leaf Base directory NOT found.\n";
        } else {
            if (!is_readable(LEAF_BASE)) {
	            $msg[] = "leaf Base directory is NOT readable.\n";
	        } else {
	            if (is_writeable(LEAF_BASE)) {
	                $msg[] = "leaf Base directory IS writeable."
	                        ."Security issues arise.\n";
	            }
	        }
        }
    }

    /*
     * LEAF_APPS
     */
    if (!defined('LEAF_APPS')) {
        $msg[] = "No leaf Application directory is defined - "
                ."Missing \"LEAF_APPS\" declaration.\n";
    } else {
        if (!file_exists(LEAF_APPS)) {
            $msg[] = "leaf Application directory NOT found.\n";
        } else {
            if (!is_readable(LEAF_APPS)) {
	            $msg[] = "leaf Application directory is NOT readable.\n";
	        }
        }

    }
    
    /*
     * LEAF_VAR
     */
    if (!defined('LEAF_VAR')) {
        $msg[] = "No Variable directory is defined - "
                ."Missing \"LEAF_VAR\" declaration.\n";
    } else {
        if (!is_readable(LEAF_VAR)) {
            $msg[] = "Variable directory is NOT readable.\n";
        } else {
            if (is_writable(LEAF_VAR)) {
                $msg[] = "Variable directory IS writable."
                        ."Security issues arise.\n";
            } else {
                
                if (!is_readable(LEAF_VAR . 'cache/')) {
                    $msg[] = "Cache directory is NOT readable.\n";
                } else {
                    if (!is_writeable(LEAF_VAR . 'cache/')) {
                        $msg[] = "Cache directory is NOT writable.\n";
                    }
                }
                
                if (!is_readable(LEAF_VAR . 'logs/')) {
                    $msg[] = "Logs directory is NOT readable.\n";
                } else {
                    if (!is_writeable(LEAF_VAR . 'logs/')) {
                        $msg[] = "Logs directory is NOT writable.\n";
                    }
                }
                
                if (!is_readable(LEAF_VAR . 'sigs/')) {
                    $msg[] = "Sigs directory is NOT readable.\n";
                } else {
                    if (!is_writeable(LEAF_VAR . 'sigs/')) {
                        $msg[] = "Sigs directory is NOT writable.\n";
                    }
                }
                
                if (!is_readable(LEAF_VAR . 'tmp/')) {
                    $msg[] = "Tmp directory is NOT readable.\n";
                } else {
                    if (!is_writeable(LEAF_VAR . 'tmp/')) {
                        $msg[] = "Tmp directory is NOT writable.\n";
                    }
                }
            }
        }
    }
    
    if ($checkAll) {
	    /*
	     * ETC
	     */
    	if (!file_exists(LEAF_BASE . 'Etc/')) {
	        $msg[] = "Etc directory NOT found.\n";
	    } else {
	        if (!is_readable(LEAF_BASE . 'Etc/')) {
	            $msg[] = "Etc directory is NOT readable.\n";
	        }
	    }
	    
	    /*
	     * CONFIGURATION FILES
	     */
	    $configFiles = array (
	        "autoload.php", "config.php", "database.php",
	        "hooks.php", "routes.php"
	    );
	    foreach ($configFiles as $file) {
	        if (!file_exists(LEAF_BASE . 'Etc/' . $file)) {
	            $msg[] = "Configuration file \"{$file}\", does not exist.\n";
	        } else {
	            if (!is_readable(LEAF_BASE . 'Etc/' . $file)) {
	                $msg[] = "Configuration file \"{$file}\", cannot be read.\n";
	            }
	        }
	    }
	    
	    unset($configFiles);
    }


    if (sizeof($msg)>0)
        showHtmlMessage("Sanity Check Failure", $msg, true);
}

?>
