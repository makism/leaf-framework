﻿<?php
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
 * @subpackage  front
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @filesource
 */


/**
 * Helper functions needed to start-up the framework
 * and to load its classes.
 */
require_once LEAF_BASE  . 'front/helpers/Main.php';


/**
 * Helper functions that are used to declare dependancies
 * on specific extensions, functions or leaf`s Classes.
 */
require_once LEAF_BASE  . 'front/helpers/Dependancies.php';


/**
 * Custom error and exception handling functions.
 */
require_once LEAF_BASE  . 'front/helpers/Handlers.php';


/**
 * Functions used to present errors.
 */
require_once LEAF_BASE  . 'front/helpers/Error.php';


/**
 * Custom debug functions.
 */
#require_once LEAF_BASE  . 'front/helpers/Debug.php';


/**
 * Helper functions handling hooks.
 *
 * @see leaf_Hook
 * @see leaf_Hook_Conditional
 */
require_once LEAF_BASE  . 'core/helpers/Hooks.php';


/*
 * Startup leaf`s Registry and register some basic objects.
 */
$reg = leaf_Registry::getInstance();
$reg->register(new leaf_Config());
#$reg->register(new leaf_Locale());


/*
 * Configure timezone.
 */
$timezoneSetting = (empty($reg->Config['timezone']))
                    ? @date_default_timezone_get()
                    : $reg->Config['timezone'];

date_default_timezone_set($timezoneSetting);


/*
 * Handle errors and exceptions.
 */
#set_error_handler("errorHandler");
#set_exception_handler("exceptionHandler");


/*
 * Register the logger if it has been enabled.
 */
#$reg->register(new leaf_Logger());


/*
 * Register the "base" classes that are needed
 * for leaf to work properly.
 */
$reg->register(new leaf_Router());
$reg->register(new leaf_Request());
$reg->register(new leaf_Loader());
$reg->register(new leaf_Dispatcher());
$reg->register(new leaf_Response());


/*
 * Begin output buffering.
 */
#$reg->Response->ouputBufferingStart();


/*
 * Run all hooks for level: Pre-Controller-Dispatch
 */
if ($reg->Config['allow_hooks'])
	runHooks(HOOK_PRE_CONTROLLER_DISPATCH);


/*
 * Dispatch controller.
 */
leaf_Dispatcher::invoke(
    $reg->Router->getClassName(),
    $reg->Router->getMethodName()
);


/*
 * Run all hooks for level: Post-Controller-Dispatch
 */
if ($reg->Config['allow_hooks'])
	runHooks(HOOK_POST_CONTROLLER_DISPATCH);


/*
 * Flush buffer, and turn off.
 */
#$reg->Response->outputBufferingEnd();


/*
 * Close the logger if it has been
 * requested and registered.
 */
#$reg->Log->end_flush();


/*
 * Run all hooks for level: Post-Front-Controller
 */
if ($reg->Config['allow_hooks'])
	runHooks(HOOK_POST_FRONT_CONTROLLER);


/*
 * General statistics like memory usage, parsing time and other.
 */
if ($reg->Config['enable_debug_stats'])
    require_once LEAF_BASE . 'front/Debug.php';
