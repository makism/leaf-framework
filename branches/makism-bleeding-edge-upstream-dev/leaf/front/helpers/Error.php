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
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @filesource
 * @todo
 * <ol>
 *  <li>Implement a function that will handle dependancies as
 *  optional.</li>
 *  <li>Recheck <b>all</b> functions.</li>
 * </ol>
 */


/**
 * Presents a "Page Not Found" message.
 * 
 * @param	string	$str
 * @return	void
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
function showErrorPage404($str=NULL)
{
    die();
}

/**
 * Prints styled text. Used in printing debug messages and errors.
 * 
 * @param	string	$title
 * @param	string	$str
 * @param	boolean	$die
 * @return	void
 */
function showHtmlMessage($title, $str=NULL, $die=FALSE)
{
    static $hasOutputedHtml;

	$errorMsg = (is_array($str))
	            ? implode("<br/>", $str)
	            : $str;

    if ($hasOutputedHtml==FALSE)
    echo "
        <style>
        body {
    		padding: 10px;
    		font-family: Tahoma, sans-serif;
    		font-size: 12pt;
    	}
    	.topic {
    		width: 80px;
    		overflow: hidden;
    		float: left;
	    	text-align: right;
    		padding: 0px 10px 0px 0px;
    	}
    	#msg {
    		color: red;
    		font-weight: bold;
    	}
    	#file {
    		color: green;
    		font: italic;
	    }
    	#line {
    		color: blue;
    		text-decoration: underline;
    	}
      </style>";


      echo "<div style=\"border: 1px solid #c5c5c5; padding: 10px;\">"
          ."<h2>$title</h2>"
          ."$errorMsg"
          ."</div><br />";

    $hasOutputedHtml = TRUE;
  
	if ($die)
        die();
}
