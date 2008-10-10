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
 * @subpackage  front
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version		SVN: $Id$
 * @filesource
 */


use leaf::Base as Base;
use leaf::Front::Helpers;



/**
 * Helper functions needed to start-up the framework
 * and to load its classes.
 */
require_once LEAF_BASE  . 'front/helpers/Main.php';
spl_autoload_register('leaf::Front::Helpers::__autoload');


/**
 * Helper functions that are used to declare dependancies
 * on specific extensions, functions or leaf`s Classes.
 */
require_once LEAF_BASE  . 'front/helpers/Dependancies.php';


/**
 * Custom error and exception handling functions.
 */
#require_once LEAF_BASE  . 'front/helpers/Handlers.php';


/**
 * Functions used to present errors.
 */
require_once LEAF_BASE  . 'front/helpers/Error.php';


/**
 * Custom debug functions.
 */
require_once LEAF_BASE  . 'front/helpers/Debug.php';


/**
 * Helper functions handling hooks.
 *
 * @see leaf_Hook
 * @see leaf_Hook_Conditional
 */
require_once LEAF_BASE  . 'base/helpers/Hooks.php';


/*
 * Handle errors and exceptions.
 */
#set_error_handler("errorHandler");
#set_exception_handler("exceptionHandler");


/*
 * Register the "base" classes that are needed
 * for leaf to work properly.
 */
$Config = new Base::Config();
$Locale = new Base::Locale();


/*
 * Configure locale.
 */
#setlocale(LC_ALL, $Locale->getGeneral('locale'));

/*
 * Configure timezone.
 */
#date_default_timezone_set($Locale->getGeneral('timezone'));


/*
 * Register the "base" classes that are needed
 * for leaf to work properly.
 */
#if ($Config->fetchRoute("use_static_routing")==TRUE) {
#    $Router = new leaf_Router_Static();
#} else {
    $Router = new Base::Router();
#}

#$Loader = new leaf_Loader();


/*
 * Load any extensions and/or plugins
 * that are registered for autoloading.
 */
#foreach ($Config->fetchAutoload() as $Section => $Registered) {
#	if (is_array($Registered)) {
#		foreach ($Registered as $moduleToLoad) {
#			$moduleToLoad = trim($moduleToLoad);
#			if ($Section=="extensions") {
#				use_extension($moduleToLoad);
#			} else if ($Section=="plugins") {
#				use_plugin ($moduleToLoad);
#			}
#		}
#	}
#}


/*
 * Filter all input data
 */
#if ($Config['enable_auto_xss']==TRUE) {
#	$xss = $Loader->extension("leaf.Xss");
#	$xss->filter($_GET, $_POST, $_COOKIE);
#}


/*
 * Continue loading base classes....
 */
$Dispatcher = new Base::Dispatcher();


/*
 * Extra-helper functions, for your convenience :-)
 */
require_once LEAF_BASE . "core/helpers/Request.php";


/*
 * Dispatch main controller.
 */
$Dispatcher->invoke(
    $Router->getClassName(),
    $Router->getMethodName()
);


/*
 * General statistics like memory usage, parsing time and other.
 */
/*if ($Config['enable_debug_stats'])
    require_once LEAF_BASE . 'front/Debug.php';*/