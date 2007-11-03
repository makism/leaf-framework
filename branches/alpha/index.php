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
 * @package	leaf
 * @author	Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @link        http://leaf-framework.sourceforge.net
 * @copyright	Copyright &copy; 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @version	$Id$
 * @filesource
 */


/*
 * PHP version check (at least 5.1).
 */
if (version_compare(phpversion(), '5.1', '<'))
	die('PHP versions older than 5.1 are not supported');

/*
 * We set error reporting in such level in order
 * to notify us as many as possible errors and warnings,
 * about undeclared variables and possible future incompability
 * issues.
 *
 * http://www.php.net/manual/en/ref.errorfunc.html#e-all
 * http://www.php.net/manual/en/ref.errorfunc.html#e-notice
 * http://www.php.net/manual/en/ref.errorfunc.html#e-strict
 */
error_reporting(E_ALL | E_NOTICE | E_STRICT);

/**
 * leaf`s Status and Version information.
 */
define('LEAF_REL_STATUS', 'DEV');
define('LEAF_REL_VERSION', '1.0');

/**
 * Current directory where *this* file is located.
 */
define('LEAF_WORKING_DIR', dirname(realpath(__FILE__)) . '/');

/**
 * Subdirectory in which leaf`s files are located.
 */
define('LEAF_BASE',	LEAF_WORKING_DIR . 'leaf/');	

/**
 * Subdirectory in which user`s applications are located.
 */
define('LEAF_APPS',	LEAF_WORKING_DIR . 'applications/');

/**
 * Subdirectory in which cache and temporary files are stored.
 */
define('LEAF_VAR',	LEAF_WORKING_DIR . 'var/');

/**
 * The {@link Front_Controller.php Front Controller} handles the
 * startup sequence.
 */
require_once LEAF_BASE . 'front/Front_Controller.php';

?>
