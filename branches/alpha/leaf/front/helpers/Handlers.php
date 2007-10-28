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
 * Custom error handler.
 *
 * 
 * @param	integer	$errno
 * @param	string	$errstr
 * @param	string	$errfile
 * @param	integer	$errline
 * @return	void
 */
function errorHandler($errno, $errstr, $errfile, $errline)
{
    static $errorTypes;
    
    $errorTypes = array (
        2   => "Warning",
        8   => "Notice",
        256 => "User Error",
        512 => "User Warning",
        1024=> "User Notice",
        4096=> "Recoverable Error"
    );
    
    $dieStatus = ($errno==256) ? TRUE : FALSE;
    
	showHtmlMessage(
    	$errorTypes[$errno],
    	"<div class=\"topic\">Message:</div> <span id=\"msg\">"  . $errstr
    	 . " ({$errno})</span><br/>\n".
    	"<div class=\"topic\">In file:</div> <span id=\"file\">" . $errfile
    	 . "</span><br/>\n"            .
    	"<div class=\"topic\">On line:</div> <span id=\"line\">#". $errline
    	 . "</span>\n",
    	$dieStatus
	);

    return true;
}

/**
 * Custom exception handler.
 *
 * 
 * @param	object	Exception	$ex
 * @return	void
 */
function exceptionHandler(Exception $ex)
{
	showHtmlMessage(
    	"Uncaught Exception",
        $ex->getMessage(),
    	true
	);


}

?>
