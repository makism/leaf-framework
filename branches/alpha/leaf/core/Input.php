<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * 
 * The first greek open source PHP5 framework, fast, with small footprint and
 * easily extensible.<br>
 * Το πρώτο ελληνικό framework PHP5 ανοικτού κώδικα, γρήγορο, μικρό σε μέγεθος
 * και εύκολα επεκτάσιμο.<br>
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Υλοποίηση.</li>
 * </ol>
 */
final class leaf_Input extends leaf_Base implements ArrayAccess {

    /**
     *
     *
     */
    const LEAF_REG_KEY = "input";
    
    /**
     * A unique id for each class.<br>
     * Ένα μοναδικό αναγνωριστικό για κάθε κλάση.
     *
     * @var string
     */
    const LEAF_CLASS_ID = "LEAF_INPUT-1_0_dev";
    

    /**
     *
     *
     * @var array
     */
    private $input = array (
        "get"   => array(),
        "post"  => array()
    );

    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }

    public function offsetExists($offset)
    {

    }

    public function offsetGet($offset)
    {
        
    }

    public function offsetSet($offset, $value)
    {

    }

    public function offsetUnset($offset)
    {

    }

    
}

?>
