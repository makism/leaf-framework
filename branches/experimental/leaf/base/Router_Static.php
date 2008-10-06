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
 * Processes and filters the current Uri in a static-like way.
 * 
 * This means that the user has defined some static rules
 * that will reflect the Uri. Nothing is done dynamic so
 * less resources are used.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 * @todo
 * <ul>
 *  <li>Implement.</li>
 * </ul>
 */
final class leaf_Router_Static extends leaf_Router {

    const BASE_KEY = "Router_Static";
    
    /**
     *  
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . " ()";
    }

}

