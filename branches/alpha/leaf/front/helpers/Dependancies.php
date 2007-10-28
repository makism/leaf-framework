<?php
/**
 * leaf framework
 *
 * <i>PHP version 5</i>
 * 
 * leaf is a Greek open source MVC framework in PHP.
 * Simple, fast, with a small footprint, easily extensible
 * using PHP5`s new Object Oriented capabilities and well documented.
 *
 *
 * @package		leaf
 * @subpackage  front.helpers
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @link        http://leaf-framework.sourceforge.net
 * @copyright	Copyright &copy; 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
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
 *
 * @param   string  $funcs
 * @return  boolean
 */
function dependsOnFunc($func)
{
    return function_exists($func);
}

?>
