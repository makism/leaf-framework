<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

 
/**
 * Attempt to emulate an enumeration.
 * 
 * @package     leaf
 * @subpackage  core
 * @author	Avraam Marimpis <makism@users.sourceforge.net>
 * @version	SVN: $Id$
 */
final class leaf_OutputBuffer {

    const TIDY_HANDLER  = "ob_tidyhandler";

    const GZ_HANDLER    = "ob_gzhandler";
    
    const OB_STARTED = 1;
    
    const OB_FLUSHED = 0;
    
}

/**
 * Handles the responses. Such as, what output buffer strategy will be used,
 * or sending headers etc.
 * 
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version		SVN: $Id$
 */
final class leaf_Response extends leaf_Common  {
    
    /**
     * Keep track of the ouput buffer.
     *
     * @var integer
     */
    private $outputStatus = NULL;

    /**
     * The output buffer handler that is to be used.
     *
     * @var string
     */
    private $outputHandler = NULL;

    /**
     * Internal buffer (populated by the output buffer).
     *
     * @var string
     */
    private $internalBuffer = NULL;
    
    /**
     * Http headers that are to be sent.
     * 
     * @var array
     */
    private $headers = NULL;
	
	
	/**
	 * Associates with the specified controller.
	 * 
	 * @return	void
	 */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);
	}

    /**
     * Setups the output buffer handler.
     *
     * @param   string $handler
     * @return  void
     */
    public function setOutputHandler($handler=NULL)
    {
        if ($handler!=NULL) {
            $name = constant("leaf_OutputBuffer::" . strtoupper($handler) . "_HANDLER");
            if (function_exists($name)) {

                if ($handler=="tidy") {
                    // Check if automatic html cleanup is enabled.
                        if (ini_get("tidy.clean_output")==FALSE) {
                            // log it
                        }

                } else if ($handler=="gz" || $handler=="gzip") {
                    // Check if `zlib.output_compression` is enabled...
                    // Err, we don`t want it to be :)
                        if (ini_get("zlib.output_compression")==TRUE) {
                            // sound an alarm!
                        }
                }

                $this->outputHandler = $name;
            }
        }

        $this->outputBufferStart($this->outputHandler);
    }

    /**
     * Returns the output buffer handler that is currently in use.
     *
     * @return string|null
     */
    public function getOutputHandler()
    {
        return $this->outputHandler;
    }

    /**
     * Start output buffering
     *
     * @return  void
     */
    public function outputBufferStart()
    {
        if ($this->outputStatus!=leaf_OutputBuffer::OB_STARTED) {
            $this->outputStatus = leaf_OutputBuffer::OB_STARTED;
            ob_start();
        }
    }

    /**
     * End output buffering
     *
     * @param   boolean $returnBuffer
     * @return  void|string
     */
    public function outputBufferFlush($returnBuffer=FALSE)
    {
        if ($this->outputStatus==leaf_OutputBuffer::OB_STARTED) {
            if ($returnBuffer) {
                return ob_get_clean();
            }

            ob_end_flush();

            $this->outputStatus = leaf_OutputBuffer::OB_FLUSHED;
        }
    }

    /**
     * Return the contents of the output buffer.
     *
     * @param   boolean $endBuffer
     * @return  string
     */
    public function getOutputBufferContents($endBuffer=FALSE)
    {
        if ($this->outputStatus!=leaf_OutputBuffer::OB_FLUSHED) {
            $this->internalBuffer = ob_get_contents();
            ob_clean();

            return $this->internalBuffer;
        } else {
            return NULL;
        }
    }

    /**
     *
     *
     * @param   string  $name
     * @param   string  $value
     * @return  void
     */
/*    public function addRawHeader($header)
    {

    }*/

    /**
     *
     *
     *
     */
/*    public function addExpireHeader($when)
    {

    }*/

    /**
     *
     *
     *
     */
/*    public function addCacheHeader($date)
    {

    }*/

    /**
     *
     *
     *
     */
/*    public function addContentTypeHeader($content, $enc)
    {

        header("");
    }*/

    /**
     *
     *
     */
/*    public function addXHeader($name, $value)
    {

        header("");
    }*/

    /**
     *
     *
     *
     */
/*    public function clearHeaders()
    {

    }*/

    /**
     * Forwards all POST and GET data to the specified Controller/Action.
     *
     * @param   mixed  $target
     * @return  void
     */
    public function forward($target)
    {
        $req = "?";
        foreach ($_POST as $key => $value) {
            $req .= $key;
            
            if ($value!=NULL)
                $req .= "=" . $value;

            if (next($_POST)!==FALSE)
                $req .= "&";
        }
        
        $headers = "POST {$req} HTTP/1.0\r\n";
        $headers.= "Content-type: application/x-www-form-urlencoded\r\n";
        $headers.= "Content-length: " . strlen($req) . "\r\n\r\n";
        
        if (is_array($target))
            $url = call_user_func_array("currentUrl", array($target, APPEND_SEGMENTS, APPEND_QUERY_STRING));
        else
            $url = currentUrl($target, APPEND_SEGMENTS, APPEND_QUERY_STRING);

        if (!empty($_POST)) {
            header($headers);
        }
        
        header("Location: " . $url);
    }
    
    /**
     * Redirects the the specified Controller/Action.
     *
     * @param   mixed  $target
     * @return  void
     */
    public function redirect($target)
    {
        if (is_array($target))
            $url = call_user_func_array("currentUrl", array($target));
        else
            $url = currentUrl($target);
        var_dump ($url);
        header("Location: " . $url);
    }
    
    /**
     * Sends an http error using a specific code, like 404.
     * 
     * The template as well as the messages can be easily modified.
     * 
     * @param   integer $code   An http error code
     * @return  void
     */
    public function sendHttpError($code)
    {
        static $errorCodes;
        
        if ($errorCodes==NULL) {
            $errorCodes = $this->Config->fetchError();
        }
        
        if ($code>=100 && $code <=500) {
            throw new leaf_Exception($errorCodes[$code], $code);
        }
    }
    
    /**
     * Raises a user error.
     * 
     * In reality, an exception is thrown, but the error code
     * indicates that is a general user error.
     *
     * @param   string  $message
     * @return  void
     */
    public function sendError($message)
    {
        throw new leaf_Exception($message, 0);
    }    

}

