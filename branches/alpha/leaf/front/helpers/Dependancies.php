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
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @filesource
 * @todo
 * <ol>
 *  <li>Implement a function that will handle dependancies as
 *  optional.</li>
 *  <li>Recheck <b>all</b> functions.</li>
 * </ol>
 */


/**
 * Handles dependacies on PHP extensions.
 * 
 * @param	string|array	$deps
 * @return	boolean
 */
function dependsOn($deps)
{
    if (is_array($deps)) {
        foreach ($deps as $dependancy)
            if (!extension_loaded($dependancy))
                showHtmlMessage(
                    "Dependancy Failure",
                    "Extension \"{$dependacy}\" not found."
                );
        die();
    } else {
        if (!extension_loaded($deps))
            showHtmlMessage(
                "Dependancy Failure",
                "Extension \"{$deps}\" not found.",
                TRUE
            );
    }

    return TRUE;
}

/**
 * Handles optional dependacies.
 *
 * @param   string  $deps
 * @return  boolean
 * @todo
 * <ol>
 *  <li>Implementd.</li>
 * </ol>
 */
function dependsOptionalOn($deps)
{
    return TRUE;
}

/**
 * Handles dependacies on specific functions.
 *
 * @param   string  $funcs
 * @return  boolean
 */
function dependsOnFunc($func)
{
    return function_exists($func);
}

?>
