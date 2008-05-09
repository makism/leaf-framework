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
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 * @filesource
 */


/**
 * Computes and returns the difference from the given unix timestamp
 * to the current timestamp.
 * 
 * The result is (will be) something like this
 * <code>
 *  1 year, 3 months, 20 days, 1 hour, 3 seconds
 * </code>
 * 
 * @param   integer $to
 * @param   integer $from
 * @param   array   $fields
 * @return  string
 * @todo
 * <ol>
 *  <li>Add l18n support.</li>
 *  <li>Add support for returning only the specified fields defined in the
 *  array 'fields'.</li>
 * </ol>
 */
function period($to, $from=NULL, array $fields=NULL)
{

}

