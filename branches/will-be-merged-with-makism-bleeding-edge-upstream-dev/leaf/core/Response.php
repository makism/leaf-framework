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
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
final class leaf_Response extends leaf_Common {
	
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
        
    }

    /**
     * 
     *
     * @return  void
     */
    public function flushOutputBuffer()
    {
        
    }

}
