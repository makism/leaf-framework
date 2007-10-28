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
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 * Προσδίδει βασικά κοινά χαρακτηριστικά στις εσωτερικές κλάσεις
 * του leaf.
 *
 * Οι περισσότερες εσωτερικές κλάσεις του leaf, κληρονομούν από
 * αυτή την κλάση.<br>
 * Τους δίνεται η δυνατότητα να έχουν πρόσβαση σε όλα τα υπόλοιπα
 * αντικείμενα που υπάρχουν. Αναφέρονται σε αυτά, σαν να ήταν απλά
 * μέλη τους.
 *
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0
 * @since		1.0-dev
 */
abstract class leaf_Base {

    /**
     * Όνομα ενός στιγμοιοτύπου αυτής τη κλάσης
     * στο οποίο θα αναφερόμαστε μέσω του αντικειμένου
     * {@link leaf_Registry}.
     *
     * @var string
     */
    const LEAF_REG_KEY = "base";
    
    /**
     * Ένα μοναδικό αναγνωριστικό για κάθε κλάση.
     *
     * @var string
     */
    const LEAF_CLASS_ID = "LEAF_BASE-1_0_dev";

    /**
     * Ένα και μοναδικό στιγμιότυπο της κλάσης leaf_Registry.
     *
     * Όλες οι υποκλάσεις "εγγράφονται" σε αυτό το αντικείμενο
     * και έχουν την δυνατότητα να αναφέρονται η μία στην άλλη.
     *
     * @var object leaf_Registry
     */
    private static $Registry = NULL;


    /**
     * Κάθε φορά που καλείται ελέγχει άν η υποκλάση είναι ήδη
     * καταχωρημένη στο αντικέμενο {@link leaf_Registry $Registry}.
     *
     * @param   NULL|string  $descendant
     * @return  void
     */
    public function __construct($descendant=NULL)
    {
        if (self::$Registry==NULL)
            self::$Registry = leaf_Registry::getInstance();

        if (self::$Registry->isRegistered($descendant))
            showHtmlMessage("Object \"{$descendant}\" already registered!", TRUE);
    }

    /**
     * Επιστρέφει το ζητούμενο αντικείμενο από την
     * {@link leaf_Registry registry}.
     *
     * @param   string  $obj
     * @return  object
     */
    protected final function __get($obj)
    {
        return self::$Registry->{$obj};
    }

    /**
     *
     *
     * @return  string
     */
    abstract public function __toString();

    /**
     *
     *
     * @return  string
     */
//    abstract public function getClassDescription();

    /**
     *
     *
     *
     *
     */
//    abstract public function getClassVersion();

    /**
     *
     *
     * @return  void
     */
    private function __clone()
    {
        return;
    }

}

?>
