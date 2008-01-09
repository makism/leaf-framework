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


global $general;
$general = array();


/*
 * Host name.
 * 
 * "http://hideo", for example.
 */
$general['hostname']  = "http://localhost:8080";


/*
 * The subdirectory in your htdocs (usually), where leaf framework`s
 * index.php is located.
 * 
 * "/leaf/", for example.
 */
$general['base_dir']  = "/leaf/";


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
 * Logging threshold. (not implemented)
 *
 * Legal values: "All", "Debug", "Warning", "Info", "None"
 * Default: "None"
 */
$general['log_level'] = "None";


/*
 * Whether to enable debug statistics.
 *
 * Legal values: TRUE, FALSE
 * Default: FALSE
 */
$general['enable_debug_stats'] = FALSE;
