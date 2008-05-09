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
 *
 * @package     leaf
 * @subpackage  core
 * @author	Avraam Marimpis <makism@users.sf.net>
 * @version	SVN: $Id$
 */
class leaf_OutputBuffer {

    const TIDY_HANDLER  = "ob_tidyhandler";

    const GZ_HANDLER    = "ob_gzhandler";
    
    const OB_STARTED = 1;
    
    const OB_FLUSHED = 0;
    
}

/**
 *
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
final class leaf_Response extends leaf_Common  {
    
    /**
     *
     *
     * @var integer
     */
    private $outputStatus = NULL;

    /**
     *
     *
     * @var string
     */
    private $outputHandler = NULL;

    /**
     *
     *
     * @var string
     */
    private $internalBuffer = NULL;
	
	
	/**
	 * 
	 * 
	 * @return	void
	 */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);
	}

    /**
     *
     *
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
     *
     *
     *
     */
    public function getOutputHandler()
    {
        return $this->outputHandler;
    }

    /**
     * Start output buffering
     *
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
     * Gets output buffer.
     *
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
    public function addRawHeader($header)
    {
        header($header);
    }

    /**
     *
     *
     *
     */
    public function addExpireHeader($when)
    {

    }

    /**
     *
     *
     *
     */
    public function addCacheHeader($date)
    {

    }

    /**
     *
     *
     *
     */
    public function addContentTypeHeader($content, $enc)
    {

    }

    /**
     *
     *
     */
    public function addXHeader($name, $value)
    {

    }

    /**
     *
     *
     *
     */
    public function clearHeaders()
    {

    }

    /**
     *
     *
     * @param   string  $target
     * @return  void
     */
    public function sendForward($target)
    {
    
    }
    
    /**
     *
     *
     * @param   string  $target
     * @return  void
     */
    public function sendRedirect($target)
    {
    
    }
    
    
    /**
     *
     *
     * @param   string  $target
     * @return  void
     */
    public function sendError($target)
    {
    
    }    

}

