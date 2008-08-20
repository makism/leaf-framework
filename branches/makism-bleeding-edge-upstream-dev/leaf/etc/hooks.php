<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */


global $hooks;
$hooks = array (

    /*
     * Init
     */
    "post_init_controller" => array(
		
    ),

    "pre_init_controller" => array(
#	"WelcomeApp" => "testHook"
    ),

    /*
     * Destroy
     */
    "post_destroy_controller" => array(
        
    ),

    "pre_destroy_controller" => array(

    )

);
