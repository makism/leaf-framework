<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * Το πρώτο ελληνικό php framework ανοικτού κώδικα, γρήγορο, μικρό σε
 * μέγεθος και εύκολα επεκτάσιμο.
 *
 *
 * @package		leaf
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 * Προσδίδει κάποια κοινά χαρακτηριστικά σε όλους του Controllers.
 *
 * Όλοι οι Controllers, <b>πρέπει</b> να κληρονομούν από αυτήν την
 * κλάση αλλιώς <b>θα αγνοούνται</b>.
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Επανέλεγχος.</li>
 *  <li>Πιθανή υλοποίηση μεθόδου "Dependacies Injection (DI)" ώστε
 *  να φορτώνονται <b>μόνο</b> οι κλάσεις που χρειάζεται ο κάθε
 *  Controller ξεχωριστά.</li>
 * </ol>
 */
abstract class leaf_Controller extends leaf_Base {

    const LEAF_REG_KEY = "controller";
    
    const LEAF_CLASS_ID = "LEAF_CONTROLLER-1_0_dev";


    /**
     * Καλεί τον parent contructor.
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

}

?>
