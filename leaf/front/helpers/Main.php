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

namespace leaf::Front::Helpers;


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
/*
    var_dump ($className);
    echo "<br/>";
*/
    if (strpos($className, "::")) {
        $className = substr($className, strrpos($className, "::")+2);
/*
        var_dump ($className);
        echo "<br/>";
*/
    }
    
    static $baseClasses;

    /*
     * Most of the leaf`s classes.
     */
    if ($baseClasses==NULL)
        $baseClasses = array (
        /** Base libraries             **/
            'Base'      => 'base/Base.php',
            'Config'    => 'base/Config.php',
            'Dispatcher'=> 'base/Dispatcher.php',
            'Exception' => 'base/Exception.php',
            'Exception_Loggable' => 'base/Exception_Loggable.php',
            'Loader'    => 'base/Loader.php',
            'Locale'    => 'base/Locale.php',
            'Router'    => 'base/Router.php',
            'Router_Static' => 'base/Router_Static.php',
            'Hook'      => 'base/Hook.php',
            'Hook_Conditional'=> 'base/Hook_Conditional.php',
            'Extension'   => 'base/Extension.php',
        /** Core libraries              **/
            'Common'    => 'core/Common.php',
            'Registry'  => 'core/Registry.php',
            'Request'   => 'core/Request.php',
            'Response'  => 'core/Response.php',
            'Controller'=> 'core/Controller.php',
            'Model'     => 'core/Model.php',
            'View'      => 'core/View.php',
            'LocalLoader'=>'core/LocalLoader.php'
        );

    /*
     * Check to dermine whether or not, the requested class
     * is part of leaf`s core.
     */
    if (array_key_exists($className, $baseClasses)) {
        require_once LEAF_BASE . $baseClasses[$className];
    }
}
