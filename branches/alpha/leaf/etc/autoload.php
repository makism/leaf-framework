<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small
 * footprint and easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο,
 * μικρό σε μέγεθος και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package		leaf
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


global $autoload;
$autoload = array();

/*
 * Plugins that will be autoloaded automatically.
 *
 * Plugins που θα φορτώνονται αυτόματα.
 */
$autoload['plugins'] = "dir";

/*
 * Extensions that will be autoloaded automatically.
 *
 * Extensions που θα φορτώνονται αυτόματα.
 */
$autoload['extensions'] = "file, image";

?>
