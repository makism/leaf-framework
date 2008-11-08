<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */


global $general;
$general = array();


/*
 * Host name.
 * 
 * "http://hideo", for example.
 */
$general['hostname']  = "http://gibson";


/*
 * The subdirectory in your htdocs (usually), where leaf framework`s
 * index.php is located.
 * 
 * "/leaf/", for example.
 */
$general['base_dir']  = "/php53/leaf2/";


/*
 *
 *
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['show_code'] = TRUE;


/*
 * Default locale settings.
 */
$general['locale'] = "el";


/*
 * The base url - created automatically.
 */
$general['base_url'] = $general['hostname'] . $general['base_dir'];


/*
 * Sandbox
 * 
 * When enabled, any access beyond the directory in which
 * leaf is installed will be denied. Also, Reflection will
 * be used to determine the Actions` declared visibility
 * and others.
 * 
 * <b>NOT IMPLEMENTED</b>
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
 * When set to TRUE, all the extensions loaded, will be
 * common among the applications.
 * When set to FALSE, every application will have it`s
 * own extensions` instances separated from every other
 * application.
 *
 * Legal values: TRUE, FALSE
 * Default: TRUE;
 */
$general['common_extensions_usage'] = TRUE;


/*
 *
 *
 *
 */
$general['enable_auto_xss'] = TRUE;


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
 * Register an output handler.
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

