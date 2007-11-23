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
 * Creates the complete Url for the current page.
 *
 * That is, it includes the Controller, the Action
 * and all the other segments.
 *
 * @return  string
 * @todo
 * <ol>
 *  <li>Implement support for the extra segments found.</li>
 * </ol>
 */
function make_link_curr() {
	static $req;

	$res = NULL;

	if ($req==NULL)
	$req = leaf_Registry::getInstance()->request;

    // Get the base url.
    $url = leaf_Registry::getInstance()->config['base_url'];

    // Controller name.
	$url .= $req->getApplicationName();

	// Attach the Action.
	if ($req->getActionName()!=NULL)
	$url .= "/" . $req->getActionName() . "/";

	// Attach the extra segments.
	if (0)
	;

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
function make_link($url, $text, array $opts=NULL)
{
	return "<a href=\"{$url}\">{$text}</a>";
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
