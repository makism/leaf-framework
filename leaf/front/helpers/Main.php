<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version		SVN: $Id$
 * @filesource
 */


/**
 * Includes all necesarry files related to leaf`s classes.
 *
 * We use the "magic" function __autoload in order
 * to have leaf`s classes loaded automatically.<br>
 * Also, {@link leaf_EndorsedManager Endorsed Manager} is
 * instantiated if needed.<br>
 *
 * <b>EndorsedManager</b> is deactivated for the time being.
 *
 * @link	http://www.php.net/manual/en/language.oop5.autoload.html
 * @see     leaf_EndorsedManager
 * @param	string $className
 * @return	void
 */
function __autoload($className)
{
    static $baseClasses;

    /*
     * Most of the leaf`s classes.
     */
    if ($baseClasses==NULL)
        $baseClasses = array (
        /** Base libraries             **/
            'leaf_Base'      => 'base/Base.php',
            'leaf_Config'    => 'base/Config.php',
            'leaf_Dispatcher'=> 'base/Dispatcher.php',
            'leaf_Exception' => 'base/Exception.php',
            'leaf_Exception_Loggable' => 'base/Exception_Loggable.php',
            'leaf_Loader'    => 'base/Loader.php',
            'leaf_Locale'    => 'base/Locale.php',
            'leaf_Router'    => 'base/Router.php',
            'leaf_Router_Static' => 'base/Router_Static.php',
            'leaf_Hook'      => 'base/Hook.php',
            'leaf_Hook_Conditional'=> 'base/Hook_Conditional.php',
            'leaf_Extension'   => 'base/Extension.php',
        /** Core libraries              **/
            'leaf_Common'    => 'core/Common.php',
            'leaf_Registry'  => 'core/Registry.php',
            'leaf_Request'   => 'core/Request.php',
            'leaf_Response'  => 'core/Response.php',
            'leaf_Controller'=> 'core/Controller.php',
            'leaf_Model'     => 'core/Model.php',
            'leaf_View'      => 'core/View.php',
            'leaf_LocalLoader'=>'core/LocalLoader.php'
        );

    /*
     * Check to dermine whether or not, the requested class
     * is part of leaf`s core.
     */
    if (array_key_exists($className, $baseClasses)) {
        require_once LEAF_BASE . $baseClasses[$className];
    }
}
