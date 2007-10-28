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
 * @subpackage  front.helpers
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @link        http://leaf-framework.sourceforge.net
 * @copyright	Copyright &copy; 2007 Avraam Marimpis
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @version		$Id$
 * @filesource
 */


/**
 * Presents a "Page Not Found" message.
 *
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

?>
