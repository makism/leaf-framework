<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright	Copyright (c) 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


global $hooks;
$hooks = array (

	/*
     * These will be executed before (pre) and
     * after (post) dispatching the requested
     * controller.
     */
    "pre_controller_dispatch"   => array(),
    "post_controller_dispatch"  => array(),

    /*
     * These hooks will be run, after the
     * Front Controller has cesead execution.
     */
    "post_front_controller"  => array()

);

?>
