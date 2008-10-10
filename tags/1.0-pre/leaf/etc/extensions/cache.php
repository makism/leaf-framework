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


global $config;
$config = array();

$config = array (
    "backend" => "file",
    "ttl"   => 60,                  // in seconds
    "group" => NULL,
    "autoSerialize" => FALSE,
    "calculateHash" => FALSE,
    "nameHash"      => "sha1",      // crc32, sha1, md5
    "securityHash"  => "sha1"       // crc32, sha1, md5, strlen
);
