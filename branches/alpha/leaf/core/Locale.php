<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small
 * footprint and easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο,
 * μικρό σε μέγεθος και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package		leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Υλοποίηση.</li>
 * </ol>
 */
final class leaf_Locale extends leaf_Base implements ArrayAccess {

    const LEAF_REG_KEY = "locale";
    
    const LEAF_CLASS_ID = "LEAF_LOCALE-1_0_dev";


    /**
     *
     *
     * @var string
     */
    private $language = NULL;

    /**
     *
     *
     * @var string
     */
    private $timestamp = NULL;
    

    /**
     *
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
     * @param   string  $offset
     * @return  string
     */
    public function offsetGet($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @param   void
     */
    public function offsetUnset($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @return  boolean
     */
    public function offsetExists($offset)
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @param   mixed   $value
     * @return  void
     */
    public function offsetSet($offset, $value)
    {

    }

}

?>
