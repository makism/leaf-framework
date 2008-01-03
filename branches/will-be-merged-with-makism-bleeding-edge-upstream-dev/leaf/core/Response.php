<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Handles the output buffering.
 *
 * That is, sents http headers, flushes the internal buffer.
 * Also, specifies an output handler like "gzip" or "tidy",
 * applying advanced functionality.
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
final class leaf_Response {
	
	/**
     *
     *
     * @var boolean
     */
	private $useTidy = FALSE;
	
	/**
     *
     *
     * @var boolean
     */
	private $useGzip = FALSE;

	/**
     *
     *
     * @var string
     */
	private $buffer = NULL;	
	
	
	/**
	 * Class constructor
	 * 
	 * 
	 * @return	void
	 */
	public function __construct()
	{
        $outputHandler = $this->Config['output_handler'];
        
        /*
         *
         */
        if (!empty($outputHandler)) {

            /*
             *
             *
             */
            if (in_array($outputHandler, ob_list_handlers())) {
                
                switch ($outputHandler) {
                    
                    /*
                     *
                     *
                     */
                    case "gz":
                        $zlibCompressionStatus = ini_get('zlib.output_compression');

                        if ($zlibCompressionStatus==FALSE)
                            $this->useGzip = TRUE;
                    break;
                    
                    /*
                     *
                     *
                     */
                    case "tidy":
                        if (extension_loaded('tidy') && function_exists('ob_tidyhandler'))
                            $this->useTidy = TRUE;
                    break;

                    default:
                    break;
                }

            }
        }
	}
    
    /**
     *
     *
     * @param   string  $name
     * @param   string  $value
     * @return  void
     */
    public function setHeader($name, $value)
    {
    }

    public function clearHeaders()
    {

    }

    /**
     *
     *
     *
     * @return  void
     */
    public function sendResponse()
    {

    }

    /**
     * Start output buffering
     *
     *
     * @return  void
     */
    public function ouputBufferingStart()
    {
        if ($this->useGzip)
            ob_start('ob_gzhandler');
        else if ($this->useTidy)
            ob_start('ob_tidyhandler');
    }

    /**
     * End output buffering
     *
     *
     * @param   boolean $returnBuffer
     * @return  void|string
     */
    public function outputBufferingEnd($returnBuffer=FALSE)
    {

    }

    /**
     * Gets output buffer.
     *
     *
     * @return  string
     */
    public function getOutputBuffer($flush=FALSE)
    {
        if ($flush)
            ob_get_flush();
        else
            return ob_get_contents();
    }

    /**
     * 
     *
     * @return  void
     */
    public function flushOutputBuffer()
    {
        ob_end_flush();
    }
    
    public function __toString()
    {
        return __CLASS__ . " (Manipulates and manages the finalized output)";
    }

}
