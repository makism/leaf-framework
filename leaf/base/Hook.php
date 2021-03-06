<?php
/**
 * This source file is part of the leaf framework and
 * is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Base class for Hook objects.
 *
 * @package 	leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Hook extends leaf_Common {
    

	/**
     *
     *
     * @return  void
     */
	public function __construct($controllerName)
	{
        parent::__construct($controllerName);
	}

	/**
	 *
	 *
	 */
	abstract public function run();

    public function __toString()
    {
        return __CLASS__ . " ()";
    }
}

