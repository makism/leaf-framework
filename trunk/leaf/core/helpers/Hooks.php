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
 * @subpackage  core.hook.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @filesource
 */


/**
 * Level, Pre Controller Dispatch
 *
 * That is, before the controller is dispatched.
 */
define('HOOK_PRE_CONTROLLER_DISPATCH', 'pre_controller_dispatch');

/**
 * Level, Post Controller Dispatch
 *
 * That is, after the controller has been executed and returned.
 */
define('HOOK_POST_CONTROLLER_DISPATCH', 'post_controller_dispatch');

/**
 * Level, Post Front Controller
 *
 * Almost, before the end of execution of the leaf framework.
 */
define('HOOK_POST_FRONT_CONTROLLER', 'post_front_controller');


/**
 * Returns the registered hooks for the requested level.
 *
 * @access  private
 * @param   string  $level
 * @return  array
 * @todo
 * <ol>
 *  <li>Refactor.</li>
 * </ol>
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
