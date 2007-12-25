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
 *
 *
 * @param	string	$key
 * @param	mixed	$value
 * @return	boolean
 */
function store($key, $value)
{
	leaf_Registry::getInstance()->Global->store($key, $value);
}

/**
 *
 *
 * @param	string	$key
 * @return	mixed
 */
function fetch($key)
{
	leaf_Registry::getInstance()->Global->fetch($key);
}

/**
 *
 *
 * @param	string	$key
 * @return	boolean
 */
function remove($key)
{
	leaf_Registry::getInstance()->Global->remove($key);
}

/**
 *
 *
 * @param	string	$key
 * @return	boolean
 */
function exists($key)
{
	leaf_Registry::getInstance()->Global->exists($key);
}

?>
