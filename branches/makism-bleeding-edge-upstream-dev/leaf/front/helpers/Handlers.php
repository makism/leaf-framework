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
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @filesource
 */


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
    
    $errorTypes = array (
        2   => "Warning",               // E_WARNING
        8   => "Notice",                // E_NOTICE
        256 => "User Error",            // E_USER_ERROR
        512 => "User Warning",          // E_USER_WARNING
        1024=> "User Notice",           // E_USER_NOTICE
        2048=> "Run-time notice",       // E_STRICT
        4096=> "Recoverable Error"      // E_RECOVERABLE_ERROR
    );
    
    $dieStatus = ($errno==256) ? TRUE : FALSE;

    $code = debug_parsefile($errfile, $errline);

echo <<<ERROR_MSG
    <br />
    <br />
    <div style="margin: 0px auto; width: 600px; overflow: hidden;">
        <div style="font-size: 16px; background-color: #f7f7da; padding: 5px;">
            <img src="/leaf/content/leaf/error.png" style="vertical-align: middle;"/>
            $errorTypes[$errno]
        </div>

        <div style="margin: 5px 0px 0px 0px; border: 1px solid #f0f0f0; padding: 10px;">
            <fieldset style="border: 0px;">
                <legend><b>Message</b></legend>
                <span style="font: Arial; font-size: 12px;">$errstr</span>
            </fieldset>

            <fieldset style="border: 0px;">
                <legend><b>Code trace</b></legend>
                <span style="font: Arial; font-size: 12px;">
                <pre>$code</pre>

                <span style="font-style: italic;">code snippet from file:</span><br />
                <span style="font-size: 10px;">$errfile</span>
                </span>
            </fieldset>
        </div>

    </div>
    <br />
    <br />
ERROR_MSG;

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

}

