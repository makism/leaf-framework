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


global $general;
$general = array();

/*
 * Host name.
 */
$general['hostname']  = "http://hideo";


/*
 * The subdirectory in your htdocs (usually), where leaf Framework`s
 * index.php is located.
 */
$general['base_dir']  = "/leaf/";


/*
 * Default application controller.
 */
$general['default_controller'] = "Blog";


/*
 *
 *
 */
$general['locale'] = "en";


/*
 * The base url - created automatically.
 */
$general['base_url']	 = $general['hostname'] . $general['base_dir'];


/*
 * Virtual file extension, shown in the address. (Optional).
 */
$general['url_suffix']= "";


/*
 * Default encoding used when necesery.
 */
$general['charset'] = "utf-8";


/*
 *
 * "Yes", "No"
 */
$general['allow_endorsed'] = "No";


/*
 *
 *
 * "Yes", "No"
 */
$general['allow_hooks'] = "No";


/*
 * Enable/Disable query strings.
 * (legal values: Yes/No).
 */
$general['allow_query_strings'] = "Yes";


/*
 * Allowed characters in the query strings.
 * Do _NOT_ set to nothing, unless you are aware of the
 * consicouences.
 */
$general['allow_query_string_chars'] = "a-z0-9-_";


/*
 * Allowed characters in the URIs. The default values are
 * the best out there.
 * Change only if sure and do _NOT_ set to nothing,
 * unless you are aware of the consicouences.
 */
$general['allow_uri_chars'] = "a-z0-9-/_:+~%*";


/*
 * Possible values inclue
 *
 * "gz", "tidy", "normal"
 */
$general['output_handler'] = "Normal";


/*
 * Which messages will be logged. Possible values are listed.
 *
 * "All", "Debug", "Warning", "Info", "None"
 */
$general['log_level'] = "None";


/*
 * Whether to show a summary of debug statistics.
 * Legal values follow.
 *
 * "Yes", "No"
 */
$general['enable_debug_stats'] = "Yes";


?>
