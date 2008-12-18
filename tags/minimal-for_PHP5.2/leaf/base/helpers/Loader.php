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
 * @author	    Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 * @filesource
 */



/**
 * Loads a plugin.
 *
 * @param   string  $plugin
 * @return  void
 */
function use_plugin ($plugin)
{
	if (!empty($plugin)) {
		leaf_Base::fetch('Loader')->plugin($plugin);
	}
}

/**
 * Loads an (orphan) extension.
 *
 * @param   string  $ext
 * @return  object leaf_Extension|NULL
 */
function use_extension ($ext)
{
	if (!empty($ext)) {
		return leaf_Base::fetch("Loader")->extension($ext, TRUE);
	}
}
