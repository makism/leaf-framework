<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf\Base;

/**
 * Base class for Hook objects.
 * 
 * Hooks, are either Objects or simple php files that can be executed
 * in pre-defined sections within an application.
 *
 * @package 	leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
abstract class Hook extends Common {
    
	/**
     * Associate with a specific Controller.
     *
     * @return  void
     */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);
	}

	/**
	 * The code to execute.
	 *
	 * @return void
	 */
	abstract public function run();

	/**
	 *
	 * @return string
	 */
    public function __toString()
    {
        return __CLASS__ . " ()";
    }
}

