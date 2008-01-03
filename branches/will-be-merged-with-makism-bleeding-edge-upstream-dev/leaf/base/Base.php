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
 * Assigns common behavior and properties in the internal classes.
 *
 * Most of the leaf`s internal classes inhertic from this class.<br>
 * This way, these classes, are provided with a unified base model,
 * to communicate (by referencing) with the other objects, as if
 * they were (private in this case) properties.<br>
 * Example
 * <code>
 *   $router = new leaf_Router();
 *   echo $router->Config['base_url'];
 * </code>
 *
 * We assume, that the "Config" property has already been instantiated and
 * automatily registered.<br>
 * Also, we assume that the access of the properties is public.
 *
 * @package     leaf
 * @subpackage  base
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Base {

    /**
     * Each time a subclass calls the constructor, some checks are
     * performed to find out if the subclass is already instantiated,
     * and thus exists in the {@link leaf_Registry $Registry}.
     *
     * @param   NULL|string  $descendant
     * @return  void
     */
    public function __construct()
    {
        
    }
    
}
