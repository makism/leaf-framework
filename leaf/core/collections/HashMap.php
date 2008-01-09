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
 * @subpackage  core.collections
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
class leaf_HashMap extends leaf_Collection {


    public function __construct(array $data=NULL)
    {
        parent::__construct($data);
    }
    
    public function clear()
    {
    
    }
    
    public function containsKey($Key)
    {
    
    }
    
    public function containsValue($Value)
    {
    
    }
    
    public function get($Key)
    {
        return $this->elements[$Key];
    }
    
    public function isEmpty()
    {
        return empty($this->elements);
    }
    
    public function put($Key, $Value)
    {
        $this->elements[$Key] = $Value;
    }
    
    public function putAll(array $Mapping)
    {
    
    }
    
    public function remove($Key)
    {
    
    }
    
    public function size()
    {
        return sizeof($this->elements);
    }
    
    public function values()
    {
    
    }
    
    public function keys()
    {
    
    }
    
    public function __toString()
    {
        
    }

}
