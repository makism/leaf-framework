<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version		SVN: $Id$
 * @filesource
 */

namespace leaf::Front::Helpers;


/**
 * Custom error handler.
 * 
 * @param   integer $errno
 * @param   string  $errstr
 * @param   string  $errfile
 * @param   integer $errline
 * @return  void
 */
function errorHandler($errno, $errstr, $errfile, $errline)
{
    static $errorTypes;
	static $showSource;
    
	if ($errorTypes==NULL) {
	    $errorTypes = array (
	        2   => "Warning",               // E_WARNING
	        8   => "Notice",                // E_NOTICE
	        256 => "User Error",            // E_USER_ERROR
	        512 => "User Warning",          // E_USER_WARNING
	        1024=> "User Notice",           // E_USER_NOTICE
	        2048=> "Run-time notice",       // E_STRICT
	        4096=> "Recoverable Error"      // E_RECOVERABLE_ERROR
	    );
	}
    
    $dieStatus = ($errno==256) ? TRUE : FALSE;

	if ($showSourceCode==NULL)
		$showSourceCode = leaf_Base::fetch('Config')->offsetGet('show_code');
	
	if ($showSourceCode==TRUE)
		$code = debug_parsefile($errfile, $errline);
    
    require LEAF_ERROR . "php_error.php";

    return TRUE;
}

/**
 * Custom exception handler.
 *
 * @param   object  Exception   $ex
 * @return  void
 */
function exceptionHandler(Exception $ex)
{
	static $showSourceCode;
	
    $code = $ex->getCode();

    // User error
    if ($code==0) {
        $message = $ex->getMessage();
        
        require LEAF_ERROR . 'generic_error.php';
    
    // Http error
    } else if ($code>=100 && $code<=500) {
        $http_code = $code;
        $http_error= $ex->getMessage();
        
        require LEAF_ERROR . "http_error.php";
        
    // Leaf error
    } else {
        $error_code     = $code;
        $error_message  = $ex->getMessage();
        $error_file     = $ex->getFile();
        $error_line     = $ex->getLine();
        $error_trace    = $ex->getTraceAsString();
		
		if ($showSourceCode==NULL)
			$showSourceCode = leaf_Base::fetch('Config')->offsetGet('show_code');
		
		if ($showSourceCode==TRUE)
			$error_scode    = $ex->getSourceCode();
        
        require LEAF_ERROR . "leaf_error.php";
    }

}

