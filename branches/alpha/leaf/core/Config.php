<?php
/**
 * leaf Framework
 *
 * <i>PHP version 5</i>
 * 
 * Το πρώτο ελληνικό php framework ανοικτού κώδικα, γρήγορο, μικρό σε
 * μέγεθος και εύκολα επεκτάσιμο.<br>
 * The first greek php frame in open source, fast with a small footprint
 * and easily extensible.
 *
 *
 * @package		leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright   -
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 * Παρέχει πρόσβαση στις ρυθμίσεις των αρχείων παραμέτρων.<br>
 *
 * Αυτή η κλάση ενθυλακώνει μέσα της όλα τα αρχεία παραμέτρων.<br>
 * Όλοι οι παράμετροι που έχουν δηλωθεί στα εξωτερικά αρχεία, είναι<br>
 * προσβάσιμοι σαν 'ονόματα δείκτες'.<br>
 * Η κλάση υλοποιεί το interface ArrayAccess. Ακολουθεί παράδειγμα πιο
 * κάτω που δείχνει την χρησιμότητα του interface ArrayAccess.<br>
 *
 * <code>
 *  $conf = new leaf_Config();
 *  echo $conf['base_uri'];
 * </code>
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @link		http://www.php.net/~helly/php/ext/spl/interfaceArrayAccess.html
 * @todo
 * <ol>
 *  <li>Προσθήκη μεθόδων/τρόπου αναφοράς στις σχεσιακές μεταβλητές.</li>
 *  <li>Η κατάργηση της global μεταβλητής $GLOBALS, ίσως πρέπει να γίνει
 *  σε άλλο σημείο του framework.</li>
 *  <li>Πιθανή υλοποίηση του interface <i>Iterator</i>.</li>
 *  <li><b>Πιθανή υλοποίηση υποκλάσης η οποία θα διαβάζει config αρχεία
 *  ξεχωριστά για κάθε τρέχων Controller, δηλώνοντας έτσι ξεχωριστές
 *  ρυθμίσεις και ίσως μοναδικές για κάθε Controller.</b></li>
 * </ol>
 */
final class leaf_Config extends leaf_Base implements ArrayAccess {

    const LEAF_REG_KEY = "config";

    const LEAF_CLASS_ID = "LEAF_CONFIG-1_0_dev";
    
	/**
	 * Όλοι οι παράμετροι θα αποθηκευθούν σε αυτό το πίνακα.
	 *
	 * @var array
	 */
	private $options = array();
	
	/**
	 * Όλοι οι παράμετροι θα αποθηκευθούν σχεσιακά (με βάση το αρχείο
     * από το οποίο διαβάζονται) σε αυτό το πίνακα.
     *
	 * @var array
	 */
	private $assocOptions = array();

	/**
	 * Συμπεριλαμβάνει όλα τα config αρχεία και αποθηκεύει τις παραμέτρους
	 * συγκεκρωτικά σε έναν πίνακα.<br>
	 *
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct(self::LEAF_REG_KEY);

		require_once LEAF_BASE . 'etc/config.php';
		require_once LEAF_BASE . 'etc/routes.php';
		require_once LEAF_BASE . 'etc/autoload.php';
		require_once LEAF_BASE . 'etc/hooks.php';
        require_once LEAF_BASE . 'etc/endorsed.php';
		
		/*$this->assocOptions['general']	= $config;
		$this->assocOptions['routes']	= $routes;
		$this->assocOptions['autoload']	= $autoload;
		$this->assocOptions['hooks']	= $hooks;*/
		
		$this->options = array_merge(
            $config, $routes, $autoload, $hooks
        );
		
    	unset($GLOBALS);
	}

	/**
	 * Ελέγχει εάν υπάρχει η παράμετρος που ζητήθηκε.
	 *
	 * @param	string	$offset
	 * @return	boolean
	 */
	public function offsetExists($offset)
	{
		if (array_key_exists($offset, $this->options))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Επιστρέφει την τιμή της παραμέτρου που ζητήθηκε.<br>
	 *
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function offsetGet($offset)
	{
		return $this->options[$offset];
	}

	/**
	 * Αποδίδει τιμή σε μία παράμετρο.
     * 
     * <i>ΧΡΗΣΙΜΟΠΟΙΕΙΤΑΙ ΜΟΝΟ ΣΤΙΣ ΕΚΔΟΣΕΙΣ ΥΠΟ-ΑΝΑΠΤΥΞΗ</i>
	 *
	 * @param	string	$offset
	 * @param	mixed	$value
	 * @return	void
	 */
	public function offsetSet($offset, $value)
	{
        if (LEAF_REL_STATUS=='DEV')
            $this->options[$offset] = $value;
	}

	/**
	 * Καταργεί μία παράμετρο.
     *
     * Καταργεί μία παράμετρο όσο τρέχει το script, δηλαδή,
     * <b>δεν ανανεώνει</b> τα αρχεία παραμέτρων.
	 *
	 * @param	string	$offset
	 * @return	void
	 */
	public function offsetUnset($offset)
	{
        unset($this->options[$offset]);
	}

    /**
     *
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->options;
    }

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }


}

?>
