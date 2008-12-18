<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LISENCE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Custom exception class with logging support.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
final class leaf_Exception_Loggable extends leaf_Exception {
    
    /**
     * 
     *
     * @param   string  $message
     * @param   integer $code
     * @return  void
     */
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
        
        // perform logging here...
    }
    
    /**
     *
     * @return  string
     */
	public function __toString()
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

    
}

