<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Base class for Hook objects, based on a conditional event.
 *
 * @package	leaf
 * @subpackage	base
 * @author	Avraam Marimpis <makism@users.sf.net>
 * @version	SVN: $Id$
 */
abstract class leaf_Hook_Conditional extends leaf_Hook {
	
    /**
     *
     *
     * @return  void
     */
	public function __construct()
	{
        parent::__construct();
	}

    /**
     * 
     *
     * @return  boolean
     */
    abstract public function condition();
    
    public function __toString()
    {
        return __CLASS__ . " ()";
    }
	
}

