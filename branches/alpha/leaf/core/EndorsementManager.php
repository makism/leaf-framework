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
 * @package     leaf
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
final class leaf_EndorsementManager extends leaf_Base {

    const LEAF_REG_KEY = "endorse_man";
    
    const LEAF_CLASS_ID = "LEAF_ENDORSEMENTMANAGER-1_0_dev";
    
 
    /**
     * Λίστα με τις τρέχουσες κλάσεις που υπερκαλύπτουν
     * αυτές του πυρήνα.
     *
     * @var array
     */
    private $endorsed = array();

    /**
     * Πίνακας με τις κλάσεις που έχουν ζητηθεί να υπερκαλύψουν
     * αυτές του πυρήνα.
     *
     * @var array
     */
    private $registeredEndorsed = array();

    /**
     * Πίνακας με τις κλάσεις που επιτρέπουμε να
     * υπερκαλύψουν τις αντίστοιχες του πυρήνα.
     *
     * @var array
     */
    private $allowEndorsement = array (
        "leaf_Locale", "leaf_Logger"
    );

    /**
     * Τρέχουσα κλάση που θα ενεργήσουμε πάνω σε αυτήν.
     *
     * @var string
     */
    private $currentClass = NULL;


    /**
     * Ανακαλύπτει τις καθορισμένες κλάσεις που θα υπερκαλυφθούν
     *
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);

        dependsOn('reflection');

        $this->registeredEndorsed = explode(",", $this->config['endorsed']);
    }

    /**
     * Έλεγχος για άν η κλάση που ζητήθηκε υποστηρίζεται.
     *
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
     * Φόρτωμα της ζητούμενης κλάσης.
     *
     *
     * @return  void
     * @todo
     * <ol>
     *  <li>Επανέλεγχος της λειτουργίας καταχώρησης των κλάσεων καθώς και
     *  των "κλειδιών" τους που χρεισιμοποιούν στο αντικείμενο
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
     * Εξετάζουμε τις δηλώσεις του αρχείου της κλάσης.
     *
     * @return  void
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     *  <li>Έλεγχος για το άν η κλάση που ελέγχουμε, έχει δηλωμένα τις
     *  σταθερές LEAF_REG_KEY ή/και LEAF_CLASS_ID.</li>
     * </ol>
     */
    private function introspectEndorsedClass($className, $fileName)
    {

    }

    /**
     * Επιστρέφει τις κλάσεις που έχουν υπερκαλύψει τις αντίστοιχες του πυρήνα.
     *
     * @return  array
     */
    public function getEndorsedClasses()
    {
        return $this->endorsed;
    }
    
}

?>
