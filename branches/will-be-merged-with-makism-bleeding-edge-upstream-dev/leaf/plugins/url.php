<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  plugins
 * @author      Marimpis Avraam <makism@users.sf.net>
 * @version     $Id$
 * @filesource
 */

 
/**
 * Flag which indicates that the Query String will be appended
 * at the end of the link.
 *
 * Used in conjuction with the "appendQueryString" function. 
 */
define("APPEND_QUERYSTRING", 1);

/**
 * Indicates that the extra segments will be appended at the link.
 *
 * Used in conjuction with the "appendQueryString" function.
 */
define("APPEND_SEGMENTS", 2);

/**
 * Merges the extra segments and the query string at the end the link.
 *
 * Used in conjuction with the "appendQueryString" function.
 */
define("APPEND_ALL", 3);

/**
 * Appends a key with the associated value to the current query string.
 *
* @see	leaf_Request
 * @param	string	$Key
 * @param	string	$Value
 * @return	void
 */
function appendQueryString($Key, $Value=NULl)
{
	leaf_Registry::getInstance()->Request->appendQueryString($Key, $Value);
}

/**
 * Merges the Query Strings. The result will be stored in the mutableQueryString.
 *
 * @see	leaf_Request
 * @return	void
 */
function mergeQueryStrings()
{
	leaf_Registry::getInstance()->Request->mergeQueryStrings();
}

/**
 * Creates the complete Url for the current page.
 *
 * That is, it includes the Controller, the Action
 * and all the other segments.
 *
 * @param	array	$opts
 * @return	string
 */
function make_link_curr(array $opts=NULL)
{
	static $req, $conf;

	$res = NULL;
	$conf = NULL;

	if ($req==NULL)
		$req = leaf_Registry::getInstance()->Request;
	
	if ($conf==NULL)
		$conf= leaf_Registry::getInstance()->Config;

    // Get the base url.
    $url = $conf['base_url'];

    // Controller name.
	$url .= $req->getApplicationName();

	// Attach the Action.
	if ($req->getActionName()!=NULL) {
		$url .= "/" . $req->getActionName();
		
		if ($conf['url_suffix']!="")
			$url .= "." . $conf['url_suffix'];
	}

	// Attach the extra segments.
	if ($req->totalSegments())
		$url .= $req->getSegments();

	// Attach the Query String.
	if ($req->getQueryString()!=NULL)
	    $url .= $req->getQueryString();

	return $url;
}

/**
 * Create an anchor, using the specific options.
 *
 * Valid options passed in the $opts array are:
 * <ul>
 *  <li><b>target</b></li>
 *  <li><b>title</b></li>
 * </ul>
 *
 * @param   string  $url
 * @param   string  $text
 * @param   array   $opts
 * @return  string
 * @todo
 * <ol>
 *  <li>Implement support for options.</li>
 * </ol>
 */
function make_href($url, $text, array $opts=NULL)
{
	return "<a href=\"{$url}\">{$text}</a>";
} 

/**
 * Produces a href link to another Action of the same or different Controller.
 *
 * Leave the "action" field blank to refer to the current Action.
 *
 * @param	string	$action
 * @param	string	$text
 * @param	integer	$opts
 * @return	string
 */
function make_link($action, $text=NULL, $opts=NULL)
{
	static $conf;

	$conf = NULL;
	
	if ($conf==NULL)
		$conf= leaf_Registry::getInstance()->Config;

	if ($action!="" || $action!=NULL) {
	// Strip the Controller from the action variable.
		if (strpos($action, "/"))
			list($controller, $action) = explode("/", $action);
		
	// Use the default Controller and Action name.
	} else {
		$controller = leaf_Registry::getInstance()->Request->getApplicationName();
		$action = leaf_Registry::getInstance()->Request->getActionName();
	}
	
    $url = $conf['base_url'];
	$ext = $conf['url_suffix'];
	
	$text = ($text==NULL) ? $action : $text;
	
	// Use the current Controller if none is specified.
	if (!isset($controller) || $controller==NULL)
		$controller = leaf_Registry::getInstance()->Request->getApplicationName();
	
	$target = $url . $controller . "/" . $action;
	
	// Append the file suffix in the Action.
	if ($ext!="")
		$target .= "." . $ext;
	
	// Process the options.
	if (isset($opts)) {
		$req = leaf_Registry::getInstance()->Request;
		switch ($opts) {
			case APPEND_SEGMENTS:
				$target .= $req->getSegments();
				break;
			case APPEND_QUERYSTRING:
				$target .= $req->getQueryString();
				break;
			case APPEND_ALL:
				$target .= $req->getSegments();
				$target .= $req->getQueryString();
				break;
		}
	}
	
	return "<a href=\"{$target}\">{$text}</a>";
}

/**
 * Generates a query string. Also, escapes strings, and calls
 * urlencode on the string.
 *
 * @param   array   $query
 * @param   boolean $convert
 * @return  string
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
function array2qstring(array $query, $convert=true)
{

}

/**
 * Converts a query string in an array.
 *
 * @param   string  $source
 * @return  array
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
function qstring2array($source)
{

}

?>
