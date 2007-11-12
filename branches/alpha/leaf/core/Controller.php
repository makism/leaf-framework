<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Assigns some common characteristics to all user`s Controllers.
 *
 * All Controller, <b>must</b> inherit from this class, otherwise
 * they will be <b>ignored</b>.
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Refactor.</li>
 *  <li>Possible implementation of "Dependacies Injection (DI)" method,
 *  so that each Controller, will load <b>only</b> the classes it
 *  depends on.</li>
 * </ol>
 */
abstract class leaf_Controller extends leaf_Base {

    const LEAF_REG_KEY = "controller";
    
    const LEAF_CLASS_ID = "LEAF_CONTROLLER-1_0_dev";


    /**
     * Calls the parent constructor.
     *
     * @return  void
     */
	public function __construct()
	{
        parent::__construct(self::LEAF_REG_KEY);
	}

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

}

?>
