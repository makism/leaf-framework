<?php
/**
 * leaf Framework<br>
 *
 * PHP version 5<br>
 *
 * Ένα ανοικτού κώδικα framework, γρήγορο, με μικρό μέγεθος και<br>
 * εύκολα επεκτάσιμο.<br>
 * An open source framework, small, with small footprint and<br>
 * easily extensible.<br>
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright		-
 * @license		-
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
final class leaf_View extends leaf_Base {

    const LEAF_REG_KEY = "view";
    
    const LEAF_CLASS_ID = "LEAF_VIEW-1_0_dev";


    /**
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
     * @return  void
     */
    public function __call($method, $args)
    {
        if ($method=="render")
            ;
        else if ($method=="view")
            ;
    }

}

?>

