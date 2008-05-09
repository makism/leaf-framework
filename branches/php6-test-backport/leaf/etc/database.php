<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
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
    // Autoconnect
    "auto_connect" => false,
    // Charset
    "charset" => ""
);


/*
 * A sample configuration.
 * Notice the indexes... 
 */
$database["profiles"]["sample"] = array (
    // Alias
    "alias" => "Db1",
    // Backend
    "backend" => "mysql",
    // Hostname
    "hostname"=> "localhost",
    // Userbane
    "username"=> "makism",
    // Password
    "password"=> "12345",
    // Port
    "port" => 3306,
    // Database name
    "db_name" => "makism",
    // Charset
    "charset" => "",
    // Autoconnect
    // Create the link upon calling bind.
    "auto_connect" => true,
    // Active Record
    "active_record_enabled" => false
);

