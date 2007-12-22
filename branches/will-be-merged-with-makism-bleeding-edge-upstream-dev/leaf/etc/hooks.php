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
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 */


global $hooks;
$hooks = array (

	/*
     * These will be executed before (pre) and
     * after (post) dispatching the requested
     * controller.
     */
    "pre_controller_dispatch"   => array(
		
	),
    "post_controller_dispatch"  => array(
		"SampleHook"
	),

    /*
     * These hooks will be run, after the
     * Front Controller has cesead execution.
     */
    "post_front_controller"  => array(
		"SampleHookConditional"
	)

);

?>
