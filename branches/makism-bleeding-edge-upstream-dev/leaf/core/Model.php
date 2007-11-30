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
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Possible removal.</li>
 * </ol>
 */
abstract class leaf_Model extends leaf_Base {
    
    const LEAF_REG_KEY = "Model";

    const LEAF_CLASS_ID = "LEAF_MODEL-1_0_dev";


    /**
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }
    
    /**
     * 
     * @return  string
     */
    public function __toString()
    {
    	
    }
    
}

?>
