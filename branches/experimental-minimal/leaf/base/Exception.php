<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LISENCE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf::Base;

/**
 * Custom exception class.
 * 
 * Here is the codes and their purpose:<br />
 * <ul>
 *  <li>0 -> 99 used by the user</li>
 *  <li>100 to 500 -> are used for http error codes</li>
 *  <li>all other -> are preserved for leaf framework</li>
 * </ul>
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 * @link	    http://php.net/manual/en/language.exceptions.html
 */
final class Exception extends Exception {
    
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
    }

    /**
     * Returns a snippet from the file in which the exception was raised. 
     *
     * @return  string
     */
    public function getSourceCode()
    {
        return debug_parsefile($this->getFile(), $this->getLine());
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


