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
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * leaf`s Status and Version information.
 */
define('LEAF_REL_STATUS', 'SVN');
define('LEAF_REL_VERSION', '1.0-alpha');

/**
 * Current directory where *this* file is located.
 */
define('LEAF_WORKING_DIR', dirname(realpath(__FILE__)) . '/');

/**
 * Subdirectory in which leaf`s files are located.
 */
define('LEAF_BASE',	LEAF_WORKING_DIR . 'leaf/');

/**
 * Subdirectory in which error template files are located.
 */
define('LEAF_ERROR', LEAF_BASE . 'error/');

/**
 * Subdirectory in which user`s applications are located.
 */
define('LEAF_APPS',	LEAF_WORKING_DIR . 'applications/');

/**
 * Subdirectory in which cache and temporary files are stored.
 */
define('LEAF_VAR',	LEAF_WORKING_DIR . 'var/');

/**
 * Subdirectory in which users` css/js/images etc, files are stored.
 */
define('LEAF_CONTENT', LEAF_WORKING_DIR . 'content/');

/**
 * The {@link Front_Controller.php Front Controller} handles the
 * startup sequence.
 */
require_once LEAF_BASE . 'front/Front_Controller.php';

