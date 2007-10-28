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
abstract class leaf_Hook_Conditional extends leaf_Hook {

    const LEAF_REG_KEY = "conditional_hook";
    
    const LEAF_CLASS_ID = "LEAF_HOOK_CONDITIONAL-1_0_dev";
    
	
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
     * @return  boolean
     */
    abstract public function condition();
	
}

?>

