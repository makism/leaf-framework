<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  base.helpers
 * @author	    Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 * @filesource
 */


/**
 * Loads a plugin.
 *
 * @return  void
 */
function use_plugin ($plugin)
{
    leaf_Registry::getInstance()->Load->plugin($plugin);
}

