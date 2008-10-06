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

 
 

$config = array();


/*
 * You can have multiple configurations.
 * Each configuration is using a unique handle,
 * specified as the array`s index.
 */

/*
 * General configuration settings
 */
$config["general"] = array (
    // Charset
    "charset" => "utf-8",
	// Result creation
	"result_creation" => DB_RESULT_CREATION_PREEMPTIVE,
	// Use backticks?
	"use_backticks" => FALSE
);


/*
 * A sample configuration.
 * Notice the array indexes... 
 */
$config["profiles"]["sample"] = array (
    // Backend
    "backend" => "mysql",
    // Hostname
    "hostname"=> "localhost",
    // Userbane
    "username"=> "username",
    // Password
    "password"=> "password",
    // Database name
    "db_name" => "db_name",
    // Port
    "port" => 3306,
    // Charset
    "charset" => "utf-8",
);

