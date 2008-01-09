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
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version  SVN: $Id$
 */
class leaf_OutputBuffer {

    const GZIP_HANDLER  = "gzip_handler";
    
    const TIDY_HANDLER  = "tidy_handler";

    const BZ2_HANDLER   = "bz2_handler";
    
    const OB_RUNNING = 1;
    
    const OB_ENDED = 0;
    
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
    
    const BASE_KEY = "Reponse";

    
    /**
     *
     *
     * @var boolean
     */
    private static $OUTPUT_STATUS = NULL;

	/**
     *
     *
     * @var string
     */
	private $buffer = NULL;	
	
	
	/**
	 * 
	 * 
	 * @return	void
	 */
	public function __construct()
	{
        parent::__construct(self::BASE_KEY, $this);
	}

###############################################################################
################################################################# Output Buffer
###############################################################################

    /**
     * Start output buffering
     *
     *
     * @return  void
     */
    public function ouputBufferStart()
    {
        self::$OUTPUT_STATUS = leaf_OutputBuffer::OB_RUNNING;
    }

    /**
     * End output buffering
     *
     *
     * @param   boolean $returnBuffer
     * @return  void|string
     */
    public function outputBufferEnd($returnBuffer=FALSE)
    {
        self::$OUTPUT_STATUS = leaf_OutputBuffer::OB_ENDED;
    }
    
    /**
     *
     *
     *
     */
    public function outputBufferFlush()
    {
    
    }

    /**
     * Gets output buffer.
     *
     *
     * @param   boolean $flush
     * @return  string
     */
    public function getOutputBuffer($flush=FALSE)
    {
        
        $buffer = $this->buffer;
        
        $this->buffer = NULL;
        
        return $buffer;
    }
    
###############################################################################
####################################################################### Headers
###############################################################################

    /**
     *
     *
     * @param   string  $name
     * @param   string  $value
     * @return  void
     */
    public function addHeader($name, $value)
    {
    
    }

    public function clearHeaders()
    {

    }
    
    
###############################################################################
######################################################################## Other
###############################################################################

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
