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
 *
 * @package		leaf
 * @subpackage	core.hook
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
abstract class leaf_Hook_Conditional extends leaf_Hook {

    const LEAF_REG_KEY = "conditional_hook";
    
    const LEAF_CLASS_ID = "LEAF_HOOK_CONDITIONAL-1_0_dev";
    
	
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
	
}

?>

