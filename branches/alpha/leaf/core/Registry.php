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
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 */


/**
 * leaf_Framework Registry Class
 *
 * Αυτή η κλάση υλοποιεί το πρότυπο σχέδιο Registry.
 * Με αυτό το τρόπο, όλα τα αντικείμενα αποθηκεύονται
 * σχεσιασιακά μέσα στην κλάση αυτή, και αναφερόμαστε μέσω
 * αυτής.
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Ίσως υπάρξει και κάποια καταχώρηση με <b>όλα</b> τα πιθανά
 *  κλειδιά που μπορεί να υπάρξουν και κάποια σημείωση για τον τύπο
 *  της κλάσης που σχετίζονται.</li>
 * </ol>
 */
final class leaf_Registry {

	/**
     *
     *
     *
     * @var array
     */
	private $registered = array();
	
    /**
     *
     *
     *
     * @var object leaf_Registry
     */
    private static $instance = NULL;
	

	/**
	 * Class constructor
	 *
	 * en: Does nothing...
	 *
	 * @return void
	 */
	private function __construct()
	{
		
	}
	
	/**
	 * instance
	 *
	 *
	 * @return object Register
	 */
	public static function instance()
	{
		if (self::$instance==NULL)
			self::$instance = new leaf_Registry();
	}

    /**
     *
     *
     * @return  object leaf_Registry
     */
    public static function getInstance()
    {
        self::instance();
        return self::$instance;
    }
	
	/**
	 * __get
	 *
	 * It is a magic method. Allows external acccess
	 * to this object`s properties. We control the
	 * properties` visibility.
	 *
	 * <code>
	 *  $instance->exampleProperty
	 * </code>
	 *
	 * @param	string	$key
	 * @return	mixed
	 */
	public function __get($key)
	{
		if ($this->isRegistered($key))
			return $this->registered[$key];
		else 
            return NULL;
	}
	
	/**
	 * __set
	 *
	 * This "magic method" completes the actions that
	 * performs the other "__get" method. It is used
	 * to set a value to a property.
	 *
	 * @param	string	$key
	 * @param	object	$obj
	 * @return	void
	 */
	private function __set($key, $obj)
	{
		if ($this->isRegistered($key)==FALSE)
			$this->registered[$key] = $obj;
	}
	
	/**
	 * register
	 *
	 *
	 * @param	object	$obj
	 * @return	void
     * @todo
     * <ol>
     *  <li>Ίσως χρειαστεί να χρησιμοποιήσουμε Reflection (αλλά μάλλον
     *  κάτι ποιο απλό) προκειμένου να ελέγχουμε για το άν έχουν
     *  δηλωθεί κάποιες σταθερές τιμές που χρειάζονται (πιθανή
     *  υλοποίηση νέας κλάσης).</li>
     * </ol>
	 */	
	public function register($obj)
    {
        $className  = get_class($obj);
        $registryKey= constant("{$className}::LEAF_REG_KEY");
                
		$this->__set($registryKey, $obj);
	}

    /**
     *
     *
     *
     * @param   string  $class
     * @return  void
     */
    public function unregister($class)
    {
        
    }

	/**
	 * isRegistered
	 *
	 *
	 * @param	string	$key
	 * @return	boolean
	 */
	public function isRegistered($key)
	{
		if (array_key_exists($key, $this->registered))
			return TRUE;
		else
			return FALSE;
	}

    /**
     *
     *
     *
     * @return  array
     */
    public function toArray()
    {
        return $this->registered;
    }

}

?>
