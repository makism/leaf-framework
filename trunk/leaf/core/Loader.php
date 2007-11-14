﻿<?php
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
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
class leaf_Loader extends leaf_Base {

    const LEAF_REG_KEY = "loader";
    
    const LEAF_CLASS_ID = "LEAF_LOADER-1_0_dev";


    /**
     *
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

    /**
     *
     *
     * @param   string  $modelName
     * @param   array   $opts
     * @return  void
     */
    public function model($modelName, $opts=NULL)
    {
    }

    /**
     *
     *
     * @param   string  $name
     * @return  void
     */
	public function library($name)
	{
		
	}
	
    /**
     *
     *
     * @param   string  $ext
     * @param   string  $namespace
     * @return  void
     */
	public function extension($ext, $namespace=NULL)
	{
	
	}

    /**
     *
     *
     * @param   string  $class
     * @return  void
     */
    public function endorsed($class)
    {

    }
	
    /**
     *
     * @param   string  $plugin
     * @return  void
     */
	public function plugin($plugin)
	{
	
	}

}

?>