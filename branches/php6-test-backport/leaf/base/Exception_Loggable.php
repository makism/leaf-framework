<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf.teicrete.gr/LICENSE  New BSD License
 * @link        http://leaf.teicrete.gr
 */


/**
 * Custom exception class.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version     SVN: $Id$
 */
final class leaf_Exception_Loggable extends leaf_Exception {
    
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
	
	public function __toString()
	{
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

    
}

