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
 * @version		SVN: $Id$
 */
abstract class leaf_Common {

    /**
     *
     *
     * @var object leaf_Registry
     */
    private $controllerRegistry = NULL;
    

    /**
     *
     *
     * @param   string  $regName
     * @return  void
     */
    public function __construct($regName)
    {
        $this->controllerRegistry = leaf_Registry::getInstance($regName);
    }
    
   	/**
     * Returns the requested object from the {@link leaf_Registry $Registry},
     * <b>or</b> the requested Model.
     * 
	 * @param  string  $key
	 * @return object|NULL
	 * @todo
	 * <ol>
	 *  <li>Support for accessing the Models using a member property named "Models".
	 *  <br>For example (<i>in Controller scope</i>):
	 *  <code>$this->Models->modelName</code> <b>or</b>
	 *  <code>$this->Models['modelName']</code><br>
	 *  This denotes changes in the {@link leaf_Loader} class as well.</li>
	 * </ol>
	 */
	protected function __get($Key)
	{
        return $this->controllerRegistry->$Key;
	}
    
    protected function __set($Id, $Key)
    {
        $this->controllerRegistry->register($Id,$Key);
    }

}
