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
 * Base class for Hook objects.
 *
 * @package		leaf
 * @subpackage	core.hook
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 */
abstract class leaf_Hook extends leaf_Base {

    const LEAF_REG_KEY = "hook";
    
    const LEAF_CLASS_ID = "LEAF_HOOK-1_0_dev";
    

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
	 */
	abstract public function run();

    /**
     *
     *
     * @return  string
     */
    public function __toString()
	{
		return __CLASS__ . " (Executes a Hook.)";
	}

}

?>
