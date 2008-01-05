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
 * @subpackage  base
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Base {

    /**
     *
     *
     * @var array
     */
    private static $BaseObjects = array ();

    
    protected function __construct($Id, $Obj)
    {
        $this->__set($Id, $Obj);   
    }

    /**
     *
     *
     */
	public function __get($Id)
	{
        return self::fetch($Id);
	}
    
    /**
     *
     *
     */
	private function __set($Id, $Obj)
	{
		if (array_key_exists($Id, self::$BaseObjects)==FALSE)
			self::$BaseObjects[$Id] = $Obj;
	}
    
    /**
     *
     *
     * @return object|NULL
     */
    public static function fetch($Id)
    {
        if (array_key_exists($Id, self::$BaseObjects))
            return self::$BaseObjects[$Id];
        else
            return NULL;
    }
    
}