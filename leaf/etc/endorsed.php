<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */


global $endorsed;
$endorsed = array();


/*
 * Array with the classes that will be endorsed.
 * Each array element, must be a string, that is
 * the classname.
 *
 * Example:
 * $endorsed[] = "Locale";
 * $endorsed[] = "Logger";
 *
 * This will notify the EndorsementManager about
 * these two classes and take the measures required.
 */
$endorsed[] = "";
