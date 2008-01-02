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
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Base {

    /**
     * The name of the instance that the current subclass
     * will known as.<br>
     * Think of it like a "key" and "value" relation.<br>
     * "key" is a name, and "value" is the actual instance
     * of a subclass.
     *
     * @var string
     */
    const LEAF_REG_KEY = "Base";
    
    /**
     * A unique handle for each subclass.
     *
     * @var string
     */
    const LEAF_CLASS_ID = "LEAF_BASE-1_0_dev";

    /**
     * The one and only unique instance of the class leaf_Registry.
     *
     * All subclasses are registered in this object and have
     * the ability to refer to other objetcts stored in the
     * registry.
     *
     * @var object leaf_Registry
     */
    private static $Registry = NULL;


    /**
     * Each time a subclass calls the constructor, some checks are
     * performed to find out if the subclass is already instantiated,
     * and thus exists in the {@link leaf_Registry $Registry}.
     *
     * @param   NULL|string  $descendant
     * @return  void
     */
    public function __construct($descendant=NULL)
    {
        if (self::$Registry==NULL)
            self::$Registry = leaf_Registry::getInstance();

        // In case the subclass is already registered, we die with a message.
        if (self::$Registry->isRegistered($descendant))
            showHtmlMessage("Internal Error!", "Object \"{$descendant}\" already registered!", TRUE);
    }

    /**
     * Returns the requested object from the {@link leaf_Registry $Registry}.
     *
     * @param   string  $obj
     * @return  object
     */
    protected function __get($obj)
    {
        return self::$Registry->{$obj};
    }

    /**
     * Prevent object cloning.
     *
     * @return  void
     */
    private function __clone()
    {
        return;
    }

    /**
     * Returns a descriptive string about this class.
     *
     * @return  string
     */
    abstract public function __toString();

}
