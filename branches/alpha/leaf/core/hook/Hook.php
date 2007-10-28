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
 * @subpackage	core.hook
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright		-
 * @license		-
 * @filesource
 */


/**
 *
 * @package		leaf
 * @subpackage	core.hook
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Υλοποίηση.</li>
 * </ol>
 */
abstract class leaf_Hook extends leaf_Loader {

    const LEAF_REG_KEY = "hook";
    
    const LEAF_CLASS_ID = "LEAF_HOOK-1_0_dev";
    

	/**
     *
     *
     * @return  void
     */
	public function __construct()
	{
        parent::__construct();
	}

    /**
     *
     *
     * @return  string
     */
    abstract public function __toString();

}

?>
