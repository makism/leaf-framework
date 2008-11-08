<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf::Base;

/**
 * Base class for Hook objects, based on a conditional event.
 * 
 * Hooks, are either Objects or simple php files that can be executed
 * in pre-defined sections within an application.
 * The hooks that implement this class, will be run, only if the
 * user-specified condition is met.
 *
 * @package 	leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class Hook_Conditional extends Hook {

    /**
     * Decides the execution of the Hook. 
     * 
     * The Hook will be executed only if TRUE is returned.
     *
     * @return  boolean
     */
    abstract public function condition();
    
    /**
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . " ()";
    }
	
}

