<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  base.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 * @filesource
 */


/**
 *
 */
define('HOOK_PRE_INIT_CONTROLLER',  'pre_init_controller');

/**
 *
 */
define('HOOK_POST_INIT_CONTROLLER', 'post_init_controller');

/**
 *
 */
define('HOOK_PRE_DESTROY_CONTROLLER',   'pre_destroy_controller');

/**
 *
 */
define('HOOK_POST_DESTROY_CONTROLLER',  'post_destroy_controller');


/**
 *
 *
 *
 */
function runControllerHooks($Controller, $level)
{
    if (!empty($Controller->hooks[$level])) {
        $currHooks = $Controller->hooks[$level];

        if (!empty($currHooks)) {
            foreach ($currHooks as $Hook) {
                require LEAF_BASE . "hooks/" . $Hook . ".php";

                if (class_exists($Hook, FALSE)) { 
                    $runHook = new $Hook($Controller->application);

                    if ($runHook instanceof leaf_Hook_Conditional) {
                        if (call_user_func(array($runHook, "condition"))===TRUE)
                            call_user_func(array($runHook, "run"));
                    } else {
                        call_user_func(array($runHook, "run"));
                    }
                }
            }
        }
    }
}

