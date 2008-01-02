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
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Collection {

    /**
     * 
     *
     * @var array
     */
    protected $elements = array();
    
    /**
     *
     *
     * @var integer
     */
    protected $pointer = NULL;

    
    /**
     *
     *
     * @param   array   $data
     * @return  void
     */
    public function __construct(array $data)
    {
        $this->elements = $data;
        $this->pointer = -1;
    }
    
    /**
     *
     *
     * @return  string
     */
    abstract public function __toString();

}
