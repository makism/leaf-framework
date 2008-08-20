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
/*
Filter out character like single quote, double quote, slash, back slash, semi colon,
extended character like NULL, carry return, new line, etc, in all strings from:
 - Input from users
 - Parameters from URL
 - Values from cookie

function filter(&$item) {
	if (is_array($item))
		foreach ($item as &$element)
			filter($element);
	else
		$item = str_replace(
					str_split("=+()*\\/"),
					NULL,
					htmlentities($item,
								ENT_QUOTES,
								"ISO-8859-1",
								TRUE
					)
		);
}
filter($_REQUEST); 
*/

$config["general"] = array (
	"non_printable" => "[\x00-\x08,\x0b-\x0c,\x0e-\x19]",
	"html_tags"		=> "javascript, vbscript, expression, applet, meta,
						xml, blink, link, style, script, embed, object,
						iframe, frame, frameset, ilayer, layer, bgsound,
						title, base",
	"sql"			=> "select, update, delete, where, limit, join, insert,
						insert into"
);

$config["_GET"] = array ();

$config["_POST"]= array ();
