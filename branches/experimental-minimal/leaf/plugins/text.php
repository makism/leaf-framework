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
 * @subpackage  plugins
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     $Id$
 * @filesource
 */
 


/**
 * Removes all punctuation characters.
 *
 * @param	string	$str
 * @retunr	string
 */
function strip_punct($str)
{
	return preg_replace ("@([[:punct:]])*?@i", "", $str);
}


/**
 * Removes all punctuation characters, and modifies the
 * passed string to camelcase.
 *
 * @param	string	$str
 * @retunr	string
 */
function camel_case($str)
{
	$phrase = strip_punct($str);
	$phrase = trim($phrase);
	$phrase	= ucwords(strtolower($phrase));
	$phrase[0]= strtolower($phrase[0]);
	$phrase = preg_replace("@(\s*?)@i", "", $phrase);
	
	return $phrase;
}


/**
 * Removes all punctuation characters and replaces the
 * spaces with dashes.
 *
 * @param	string	$str
 * @retunr	string
 */
function dashed($str)
{
    $phrase = strip_punct($str);
	$phrase = trim($phrase);
	$phrase = strtolower($phrase);
	
	return preg_replace("@[ ]+@", "-", $phrase);
}