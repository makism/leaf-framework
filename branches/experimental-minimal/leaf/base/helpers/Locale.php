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
 * @subpackage  base.helpers
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     $Id$
 * @filesource
 */

namespace leaf\Base\Helpers;


/**
 * Returns this locale`s name.
 *
 * @return	string
 */ 
function currentLocale()
{
	return leaf_Base::fetch("Locale")->getGeneral('locale');
}


/** 
 * Returns this locale`s charset.
 *
 * @return	string
 */
function currentCharset()
{
	return leaf_Base::fetch("Locale")->getGeneral('charset');
}


/** 
 * Returns the current locale (from the general settings).
 *
 * @return	string
 */
function currentLocaleSetting()
{
	return leaf_Base::fetch("Config")->offsetGet("locale");
}


/**
 * Converts a string from one encoding to another.
 * 
 * Underneath, <b>iconb</b> or <b>mb</b> is used.
 *
 * @param	string	$str
 * @param	string	$from
 * @param	string	$to
 * @return	string|NULL
 */
function encodeString($str, $from, $to)
{
	if (extension_loaded('iconv'))
		return iconv($from, $to, $str);
	
	if (extension_loaded('mbstring'))
		return mb_convert_encoding($str, $to, $from);
	
	return NULL;
}
