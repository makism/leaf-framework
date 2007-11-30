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
 * "hideo", for example.
 */
$general['hostname']  = "http://hostname";


/*
 * The subdirectory in your htdocs (usually), where leaf Framework`s
 * index.php is located.
 * "/leaf", for example.
 *
 */
$general['base_dir']  = "/";


/*
 * Default application controller.
 */
$general['default_controller'] = "SampleApplication";


/*
 * Default locale settings.
 */
$general['locale'] = "en";


/*
 * The base url - created automatically.
 */
$general['base_url'] = $general['hostname'] . $general['base_dir'];


/*
 * Virtual file extension, shown in the address. (not implemented)
 *
 * Default: "";
 */
$general['url_suffix']= "";


/*
 * Default encoding used when necesery.
 */
$general['charset'] = "utf-8";


/*
 * Enable or disable the endorsement mechanism, so you may
 * substitute internal core classes, with other implementations.
 *
 * Legal values: "Yes", "No"
 */
$general['allow_endorsed'] = "No";


/*
 * Enable or disable the "hooking" mechanism.
 * This enables you to interpose your code
 * easily, in predefined places.
 *
 * Legal values: "Yes", "No"
 * Default: "No"
 */
$general['allow_hooks'] = "No";


/*
 * Enable/Disable query strings.
 *
 * Legal values: "Yes", "No"
 * Default: "Yes"
 */
$general['allow_query_strings'] = "Yes";


/*
 * Allowed characters in the query strings.
 * Do _NOT_ set to nothing, unless you are aware of the
 * consicouences.
 *
 * Default value: "a-z0-9-_"
 */
$general['allow_query_string_chars'] = "a-z0-9-_";


/*
 * Allowed characters in the URIs. The default values are
 * the best out there.
 * Change only if sure and do _NOT_ set to nothing,
 * unless you are aware of the consicouences.
 *
 * Default value: "a-z0-9-/_:+~%*"
 */
$general['allow_uri_chars'] = "a-z0-9-/_:+~%*";


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
 * Legal values: "Yes", "No"
 * Default: "Yes"
 */
$general['enable_debug_stats'] = "No";


?>
