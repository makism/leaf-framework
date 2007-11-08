<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small footprint and
 * easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο, μικρό σε μέγεθος
 * και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package     leaf
 * @subpackage  core.hook.helpers
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 *
 *
 */
define('HOOK_PRE_CONTROLLER_DISPATCH', 'pre_controller_dispatch');

/**
 *
 *
 */
define('HOOK_POST_CONTROLLER_DISPATCH', 'post_controller_dispatch');

/**
 *
 *
 */
define('HOOK_POST_FRONT_CONTROLLER', 'post_front_controller');


/**
 *
 *
 *
 * @access  private
 * @param   string  $level
 * @return  array
 */
function introspectHooks($level=NULL)
{
    if ($level!=NULL)
        if (!defined('HOOK_' . strtoupper($level)))
            throw new leaf_Exception("Unknown Hook Level!");
    
    static $allHooks;

    if ($allHooks==NULL)
        $allHooks = leaf_Registry::getInstance()->config->hooks;

    if ($level!=NULL)
        return $allHooks[$level];
    else
        return $allHooks;
}

/**
 * Runs all registered hooks in one level.
 *
 * @access  private
 * @param   string  $level
 * @return  void
 */
function runHooks($level)
{
    $hooks = introspectHooks($level);
}

/**
 * Executes a specific hook.
 *
 * @access  private
 * @param   string  $controller
 * @param   string  $method
 * @return  void
 */
function runHook($controller, $method)
{

}

/**
 * Returns all registered hooks for one -or all- level. Also, the hooks
 * can be filtered using the parameters $controller and $method.
 *
 * @param	string|NULL	$level
 * @param	string|NULL	$controller
 * @param	string|NULL	$method
 * @return	array
 */
function getHooks($level=NULL, $controller=NULL, $method=NULL)
{

}

?>
