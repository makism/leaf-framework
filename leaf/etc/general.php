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
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */


global $general;
$general = array();


/*
 * Host name.
 * 
 * "http://hideo", for example.
 */
$general['hostname']  = "http://localhost";


/*
 * The subdirectory in your htdocs (usually), where leaf framework`s
 * index.php is located.
 * 
 * "/leaf/", for example.
 */
$general['base_dir']  = "/";


/*
 * Default locale settings.
 */
$general['locale'] = "en";


/*
 * The base url - created automatically.
 */
$general['base_url'] = $general['hostname'] . $general['base_dir'];


/*
 * Default encoding used when necesery.
 */
$general['charset'] = "utf-8";


/*
 * Default timezone used.
 */
$general['timezone']= "Europe/Athens";


/*
 * Sandbox
 * 
 * When enabled, any access beyond the directory in which
 * leaf is installed will be denied. Also, Reflection will
 * be used to determine the Actions` declared visibility
 * and others.
 * 
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['enable_sandbox'] = FALSE;


/*
 * The term "Controller behavior" describes a set of "switches"
 * that can be set into your Controller, in order to gain "behavior".
 * The switches that are set by default are:
 *
 * Allows or prohibits to other Controllers to invoke the Controller
 * that defines uses "ALLOW_CALL" switch.
 * Legal values: TRUE, FALSE
 * > ALLOW_CALL = TRUE
 *
 * Enables of Disables the usage of the Controller.
 * Legal values: TRUE, FALSE
 * > IS_ENABLED = TRUE and
 *
 * Restricts the usage of the Controller, only from localhost.
 * Legal values: TRUE, FALSE
 * > RESTRICT_ACCESS = FALSE
 *
 * Legal values: TRUE, FALSE
 * Default: TRUE
 */
$general['enable_controller_behavior'] = TRUE;


/*
 * Enable or disable the endorsement mechanism, so you may
 * substitute internal core classes, with other implementations.
 *
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['allow_endorsed'] = FALSE;


/*
 * Enable or disable the "hooking" mechanism.
 * This enables you to interpose your code
 * easily, in predefined places.
 *
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['allow_hooks'] = FALSE;


/*
 * Register an output handler. (not implemented)
 *
 * Legal values: "gz", "tidy", "normal"
 * Default: "normal"
 */
$general['output_handler'] = "normal";


/*
 * Whether to enable debug statistics.
 *
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['enable_debug_stats'] = FALSE;

