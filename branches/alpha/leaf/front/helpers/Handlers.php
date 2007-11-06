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
 * @version		$Id$
 * @filesource
 * @todo
 * <ol>
 *  <li>Implement a function that will handle dependancies as
 *  optional.</li>
 *  <li>Recheck <b>all</b> functions.</li>
 * </ol>
 */


/**
 * Custom error handler.
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
