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
 * @version     SVN: $Id$
 */


global $route;
$route = array();


/*
 * Default application controller.
 */
$route['default_route'] = "WelcomeApp";


/*
 * Enable/Disable query strings.
 *
 * Legal values: TRUE, FALSE
 * Default: TRUE
 */
$route['allow_query_strings'] = TRUE;


/*
 * Virtual file extension, shown in the Uri.
 *
 * Default: "xml";
 */
$route['url_suffix']= "xml";


/*
 * Allowed characters in the query strings.
 * Do _NOT_ set to nothing, unless you are aware of the
 * consicouences.
 *
 * Default value: "a-z0-9-_"
 */
$route['allow_query_string_chars'] = "a-z0-9-_";


/*
 * Allowed characters in the URIs. The default values are
 * the best out there.
 * Change only if sure and do _NOT_ set to nothing,
 * unless you are aware of the consicouences.
 *
 * Default value: "a-z0-9-/_:+~%*"
 */
$route['allow_uri_chars'] = "a-z0-9-/_:+~%*";


/**
 * When set to TRUE, you have the ability to retrieve caller
 * Controller that invoked another Controller.
 * Although this seems like a memory-consuming feature, in
 * fact it`s overhead is about ~1kb for a simple controller.
 * It should be used only if advanced Controller handling
 * is required.
 *
 * Default: FALSE.
 */
$route['trace_dispatches'] = FALSE;
