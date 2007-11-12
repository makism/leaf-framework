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
 * </ol>
 */
final class leaf_Input extends leaf_Base implements ArrayAccess {

    const LEAF_REG_KEY = "input";
    
    const LEAF_CLASS_ID = "LEAF_INPUT-1_0_dev";
    

    /**
     * Array with references to the super global
     * variables "post" and "get".
     *
     * @var array
     */
    private $input = array (
        "get"   => array(),
        "post"  => array()
    );

    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }

    public function offsetExists($offset)
    {

    }

    public function offsetGet($offset)
    {
        
    }

    public function offsetSet($offset, $value)
    {

    }

    public function offsetUnset($offset)
    {

    }

    
}

?>
