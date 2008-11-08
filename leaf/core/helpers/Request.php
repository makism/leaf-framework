<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  core.helpers
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 * @filesource
 */

#namespace leaf::Core::Helpers;
use leaf::Base as Base;
use leaf::Core as Core;

/**
 *
 */
define('APPEND_SEGMENTS', 1);

/**
 *
 */
define('APPEND_QUERY_STRING', 2);

/**
 * Returns the base directory.
 *
 * @return	string
 */
function baseDir() {
    $Config = Base::Base::fetch("Config");
    return $Config['base_dir'];
}


/**
 * Returns tha base url address.
 *
 * @return	string
 */
function baseUrl() {
    $Config = Base::Base::fetch("Config");
    return $Config['base_url'];
}


/**
 * Returns the current Url.
 *
 * This (pretty complex) function takes from zero to a couple of arguments.
 * When 0 arguments are passed, the current Url with the requested Controller/Action is returned. (something like $_SERVER['PHP_SELF'])
 * When passing any arguments, keep in mind that:
 * <ol>
 *  <li>The first argument, if it`s an array, specifies the Controller and the Action.</li>
 *  <li>The first argument, if it`s a string, specifies the Action (from the running Controller).</li>
 *  <li>
 *      If you want to append any segment to the Url, first of all you must specify
 *      the action and then pass an array (with the segments), and the <b>next</b> argument
 *      must be the constant "APPEND_SEGMENTS". For example:
 *      <code>currentUrl('action', $segmentsArray, APPEND_SEGMENTS);</code>
 *  </li>
 *  <li>
 *      If you want to append any query strings, you must use the instructions described above.
 *  </li>
 *  <li>
 *      You can also just define an action (string), or an array with the controller/action
 *      and pass either one of/or both constants "APPEND_SEGMENTS", "APPEND_QUERY_STRING".
 *      <code>currentUrl('action', APPEND_QUERY_STRING);</code>
 *      <code>currentUrl('action', APPEND_SEGMENTS, APPEND_QUERY_STRING);</code>
 *      The segments and/or the query string appended, will be taken (if any) from the Request object. 
 *  </li>
 * </ol>
 * Passing <b>all</b> arguments is done in a specific order:
 * <ol>
 *  <li>array("controllerName", "actionName") | string $actionName</li>
 *  <li>array("segment1", "segment2", "segment3")</li>
 *  <li>APPEND_SEGMENTS</li>
 *  <li>array("key1" => "value1", "key2" => "value2")</li>
 *  <li>APPEND_QUERY_STRING</li>
 * </ol>
 * 
 * This function maybe seem complex, but, by far it`s the most useful one.
 * Master it ;-)
 * 
 *
 * @param	array	$targetApp
 * @param	string	$action
 * @return	string
 */
function currentUrl() {
	$args	= func_get_args();
	$total	= func_num_args();
	
	$dsp	= Base::Base::fetch("Dispatcher");
	$app	= $dsp->getCurrentController();
	$reg	= Core::Registry::getInstance($app);
	
	$controller = NULL;
	$action		= NULL;
	$segments	= NULL;
	$queryString= NULL;
	
	for ($i=0; $i<$total; $i++) {
		$arg = $args[$i];
		
		if (is_array($arg) && $controller==NULL && $action==NULL) {
			$controller= $arg[0];
			$action    = $arg[1];
			continue;
		}
		
		if (is_string ($arg) && $action==NULL) {
			$controller = Base::Base::fetch('Dispatcher')->getCurrentController();
			$action = $arg;
			continue;
		}
		
		if (is_array($arg) && $segments==NULL && $args[$i+1]===APPEND_SEGMENTS) {
			$reg->Request->setSegments($arg);
			$segments = $reg->Request->getRawSegments();
			$i++;
			continue;
		}
		
		if ($arg===APPEND_SEGMENTS) {
			$segments= $reg->Request->getRawSegments();
			continue;
		}
		
		if (is_array($arg) && $queryString==NULL && $args[$i+1]===APPEND_QUERY_STRING) {
			$reg->Request->setQueryString($arg);
			$queryString = $reg->Request->getQueryString();
			$i++;
			continue;
		}
		
		if ($arg===APPEND_QUERY_STRING) {
			$reg->Request->setQueryString($_GET);
			$queryString = $reg->Request->getQueryString();
			continue;
		}
		
	}
	
	if ($controller==NULL)
		$controller = $dsp->getCurrentController();
	
	if ($action==NULL)
		$action		= $dsp->getCurrentAction();
	
	if (Base::Base::fetch('Config')->fetchRoute('url_suffix')!=NULL)
		$action .= "." . Base::Base::fetch('Config')->fetchRoute('url_suffix');
	
	return baseUrl() . $controller . "/" . $action . $segments . $queryString;
}


/**
 * Returns the current url, with the segments (if any) and the query string (if any).
 *
 * @return  string
 */
function currentFullUrl()
{
	return currentUrl(APPEND_SEGMENTS, APPEND_QUERY_STRING);
}
