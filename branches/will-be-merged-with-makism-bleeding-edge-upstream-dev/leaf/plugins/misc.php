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
 * Converts a boolean value, to the text tha represents that value.
 *
 * @param	string	$var
 * @return	string
 */
function boolean2text($var)
{
	if (is_bool($var))
		return ($var) ? "true" : "false";
	else
		return $var;
}

?>
