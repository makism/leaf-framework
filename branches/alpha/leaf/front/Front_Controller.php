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
 * @subpackage  front
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @link        http://leaf-framework.sourceforge.net
 * @copyright	Copyright &copy; 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @version		$Id$
 * @filesource
 * @todo
 * <ol>
 *  <li>Add functionality for the 'hooks' subsystem.</li>
 *  <li>Add functionality for the benchmarking subsystem.</li>
 *  <li>Completetion of the documentation.</li>
 * </ol>
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
require_once LEAF_BASE  . 'front/helpers/Debug.php';

/**
 * Helper functions handling hooks.
 *
 * @see leaf_Hook
 * @see leaf_Hook_Conditional
 */
require_once LEAF_BASE  . 'core/hook/helpers/Hooks.php';


/*
 * Perform some basic checks to determine whether or not
 * the system`s sanity (and thus, all will be run normal).
 */
#frameworkSanityCheck();


/*
 * Startup leaf`s Registry and register some basic objects.
 */
$reg = leaf_Registry::getInstance();
$reg->register(new leaf_Config());
$reg->register(new leaf_Locale());
#$reg->register(new leaf_Benchmark());


/*
 * Configure timezone.
 */
$timezoneSetting = (empty($reg->config['timezone']))
                    ? @date_default_timezone_get()
                    : $reg->config['timezone'];

date_default_timezone_set($timezoneSetting);


/*
 * Handle errors and exceptions.
 */
#set_error_handler("errorHandler");
#set_exception_handler("exceptionHandler");


/*
 * 
 */
#if ($reg->config['log_level']!="None" ||
#    empty($reg->config['log_level'])) {
#    $reg->register(new leaf_Logger());
#}

/*
 *
 */
$reg->register(new leaf_Router());
$reg->register(new leaf_Request());
$reg->register(new leaf_Loader());
$reg->register(new leaf_Dispatcher());
$reg->register(new leaf_Response());


/*
 *
 *
 */
# Hooks ########
# Pre-Response #
################
$reg->response->ouputBufferingStart();


/*
 * 
 */
# Hooks ###################
# Pre-Controller-Dispatch #
###########################

$reg->dispatcher->dispatchController();

# Hooks ####################
# Post-Controller-Dispatch #
############################


/*
 *
 */
$reg->response->outputBufferingEnd();
# Hooks #######
# Post-Response
###############


/*
 *
 */
#if ($reg->isRegistered("logger"))
#    $reg->logger->end_flush();


#Hooks ##################
# Post-Front-Controller #
#########################
#runHooks(HOOK_POST_FRONT_CONTROLLER);

/**
 * General statistics like memory usage, parsing time and other.
 */
if ($reg->config['enable_debug_stats']=="Yes")
    require_once LEAF_BASE . 'front/Debug.php';
?>
