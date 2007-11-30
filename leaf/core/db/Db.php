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
 * @package     leaf
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
final class leaf_Db extends leaf_Base {

    const LEAF_REG_KEY = "Db";
    
    const LEAF_CLASS_ID = "LEAF_DB-1_0_dev";
    
    
    /**
     * 
     * 
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