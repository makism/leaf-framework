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
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 */


global $database;
$database = array();


/*
 * You can have multiple configurations.
 * Each configuration is using a unique handle,
 * specified as the array`s index.
 */

/*
 * General configuration settings
 */
$database["general"] = array (
    // Default profile
    "defaultProfile" => "default",
);


/*
 * A sample configuration.
 * Notice the indexes... 
 */
$database["profiles"][]["default"] = array (
    // Backend
    "backend" => "mysqli",
    // Hostname
    "hostname"=> "localhost",
    // Userbane
    "username"=> "username",
    // Password
    "password"=> "password",
    // Port
    "port" => 3306,
    // Database name
    "dbName" => "dbName",
    // Charset
    "charSet" => ""
);

/*
 * Another sample configuration
 */
$database["profiles"][]["sample"] = array (

);

?>
