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
 * Provides a common base layout for all Models.
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		SVN: $Id$
 * @todo
 * <ol>
 *  <li>For security issues, restrict it's access to specific resources.</li>
 *  <li>Possible removal.</li>
 * </ol>
 */
abstract class leaf_Model extends leaf_Common {

    /**
     *
     * @return  void
     */
    public function __construct($controllerName)
    {
        parent::__construct($controllerName);
    }
    
    /**
     *
     *
     * @return  void
     */
    abstract public function init();
    
    /**
     *
     *
     * @return  void
     */
    public function destroy()
    {
        return;
    }
    
}
