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
 * @subpackage  core.db
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     $Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 *  <li>Document.</li>
 * </ol>
 */
final class leaf_Db_ActiveRecord {

    
    /**
     * 
     *
     */
    public function __construct(leaf_Db_Backend $frontEnd)
    {

    }
    
    /**
     * Used to retrieve a field`s value.
     *
     * @param   string  $field
     * @return  mixed
     */
    public function __get($field)
    {
        
    }

    /**
     * Changes the field`s value.
     *
     * @param   string  $field
     * @param   string  $value
     * @return  boolean
     */
    public function __set($field, $value)
    {
        
    }
    
    /**
     * All the "Active Record" magic is implemented here...
     *
     * @param   string  $method
     * @param   array   $args
     * @return  mixed
     */
    public function __call($method, $args)
    {
        $m = $method;
        $a = $args;
        $s = sizeof($a);
        
        
    }
    
}

?>