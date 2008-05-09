<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 *
 *
 * @package     leaf
 * @subpackage  core
 * @author  	Avraam Marimpis <makism@users.sf.net>
 * @version	    SVN: $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
final class leaf_Locale extends leaf_Base implements ArrayAccess {

    /**
     *
     *
     * @var string
     */
    private $language = NULL;

    /**
     *
     *
     * @var string
     */
    private $timestamp = NULL;
    

    /**
     *
     *
     *
     * @return  void
     */
    public function __construct()
    {
    
        
    }

    /**
     *
     *
     * @param   string  $offset
     * @return  string
     */
    public function offsetGet($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @param   void
     */
    public function offsetUnset($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @return  boolean
     */
    public function offsetExists($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @param   mixed   $value
     * @return  void
     */
    public function offsetSet($offset, $value)
    {

    }

    public function __toString()
    {
        return __CLASS__ . " (Supports your localization needs)";
    }

}

