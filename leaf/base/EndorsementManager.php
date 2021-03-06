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
 * Handles the requests, to overlap the internal implementations of specific
 * classes, with external, in userspace-like fashion.
 *
 * This way, the framework can easily be updated, and hacked - allowing
 * the users to provide their own implementations of specific classes.
 *
 * @package 	leaf
 * @subpackage	base
 * @author      Avraam Marimpis <makism@users.sf.net>
 * @version     SVN: $Id$
 */
final class leaf_EndorsementManager extends leaf_Base {

    const BASE_KEY = "EndorsementManager";

    
    /**
     * Currently classes that are overlapped.
     *
     * @var array
     */
    private $endorsed = array();

    /**
     * Array with the classes that have been requested to be
     * overlapped.
     *
     * @var array
     */
    private $registeredEndorsed = array();

    /**
     * Array with the classes that are allowed to be overlapped.
     *
     * @var array
     */
    private $allowEndorsement = array (
        "leaf_Locale", "leaf_Logger"
    );

    /**
     * Current class that we will work on.
     *
     * @var string
     */
    private $currentClass = NULL;


    /**
     * Discovers the classes that are declared for overlapping.
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::BASE_KEY, $this);
        
        dependsOn('reflection');
        
        $this->registeredEndorsed = explode(",", $this->Config['endorsed']);
    }

    /**
     * Find out if the requested class is endorsed for overlapping.
     *
     * @return  boolean
     */
    public function isEndorsed($className)
    {
        if (in_array($className, $this->allowEndorsement))
            if (in_array(preg_replace("@^(leaf_)@", "", $className), $this->registeredEndorsed))
                return TRUE;


        return FALSE;
    }

    /**
     * Load the requested class.
     *
     *
     * @return  void
     * @todo
     * <ol>
     *  <li>Check again the registration function that the classes are
     *  using, as well as the "keys" that they use in the class
     *  {@link leaf_Registry}.</li>
     * </ol>
     */
    public function loadEndorsedClass($className)
    {
        $className = trim($className);

        $fileName = preg_replace("@^(leaf_)@", "", $className);

        $this->introspectEndorsedClass($className, $fileName);

        require_once LEAF_BASE 
                    . 'endorsed/'
                    . $fileName
                    . '.php';

        $this->endorsed[][$className]['reg_key'] = constant("{$className}::LEAF_REG_KEY");
        
    }

    /**
     * Introspect the class` file.
     *
     * @return  void
     * @todo
     * <ol>
     *  <li>Implement.</li>
     *  <li>Must check if the class, has declared the constants
     *  LEAF_REG_KEY and/or LEAF_CLASS_ID.</li>
     * </ol>
     */
    private function introspectEndorsedClass($className, $fileName)
    {

    }

    /**
     * Returns all the classes, that are currently overlapping the
     * internal classes.
     *
     * @return  array
     */
    public function getEndorsedClasses()
    {
        return $this->endorsed;
    }

    public function __toString()
    {
        return __CLASS__ . " (Supports the endorsed mechanism)";
    }
    
}

