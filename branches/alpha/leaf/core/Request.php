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
 * Παρέχει πρόσβαση σε όλα τα διακριτά στοιχεία του Uri.
 *
 * Δηλαδή έχουμε την δυνατότητα να αναφερθούμε και να ζητήσουμε
 * το αρχείο από το οποίο θα φορτώσουμε τον Controller, το Action,
 * τα επιπλέον στοιχεία (segments), και τέλος το query string στη
 * κλασσική του μορφή όπως η super-global μεταβλητή $_GET.<br>
 * Τέλος, υλοποιεί γενικές μεθόδους σχετικές με την ανακατεύθυνση
 * σε μία διεύθυνση και αναδημιουργία ενός Uri.
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Υλοποίηση πιθανών facade συναρτήσεων.</li>
 * </ol>
 */
final class leaf_Request extends leaf_Base {

    const LEAF_REG_KEY = "request";
    
    const LEAF_CLASS_ID = "LEAF_REQUEST-1_0_dev";


    /**
     * Τα επιπλέον κομμάτια του Uri που δεν ανήκουν ούτε
     * στον Controller ούτε στο Action.
     *
     * παράδειγμα:
     *  <pre>http://localhost/Blog/view/200X-XX-XX/authorName/postTitle</pre>
     * οτιδήποτε μετά το "view", θα θεωρηθεί επιπλέον
     * στοιχείο.
     *
     *
     * @var array
     */
    private $segments = NULL;

    /**
     * Το κανονικό όνομα της κλάσης του Controller που 
     * έχει ζητηθεί.
     *
     * @var string
     */
    private $controller = NULL;

    /**
     * Το όνομα του αρχείου από όπου θα πρέπει να φορτώσουμε τον
     * ζητούμενο Controller.
     *
     * Το περιεχόμενο θα μοιάζει (τουλάχιστον τα τελευταία στοιχεία)
     * κάπως έτσι:
     * <pre>/var/www/http/applications/Blog/Blog_Controller.php</pre>
     *
     * @var string
     */
    private $controllerFile = NULL;
    
    /**
     * Το όνομα του συγκεκριμένου Action(μεθόδου).
     *
     * @var string
     */
    private $action = NULL;

    /**
     * Τα στοιχεία του Query String (άν υπάρχουν και έχουν έχουν
     * ενεργοποιηθεί).
     *
     * @var array
     */
    private $queryElems = NULL;


    /**
     * Συνεργάζεται με την κλάση {@link leaf_Router} προκειμένου
     * να δώσει πρόσβαση στον χρήστη πληροφορίες όπως, το όνομα
     * της κλάσης του Controller που ζητήθηκε, όπως <i>θα πρέπει</i>
     * να έχει ονομαστεί, το Action, κτλ κτλ κτλ.
     *
     * @return  void
     */
	public function __construct()
	{
        parent::__construct(self::LEAF_REG_KEY);

        /*
         * Τα ονόματα των κλάσεων τελειώνουν με το χαρακτηριστικό
         * "_Controller", οπότε και το προσδίδουμε εμείς.
         */
        $this->controller   = $this->router->getClassName() . '_Controller';

        /*
         * Συνθέτουμε το πλήρες όνομα του αρχείου (με τον κατάλογο) όπου
         * θα φορτώσουμε την κλάση του Controller.
         */
        $this->controllerFile =
            LEAF_APPS
            . $this->router->getClassName()
            . '/'
            . $this->controller
            . '.php';

        /*
         * Ζητάμε το Action(Μέθοδο) από το αντικείμενο router.
         */
        $this->action       = $this->router->getMethodName();

        /*
         * Ζητάμε τα επιπλέον στοιχεία του Uri από το αντικείμενο
         * router.
         */
        $this->segments     = $this->router->segments();

        /*
         * Ζητάμε τα στοιχεία του Query String από το αντικείμενο
         * router.
         */
        $this->queryElems   = $this->router->queryStringElements();
	}


    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

	/**
	 *
	 * @return	string
	 */
    public function getControllerName()
    {
        return $this->controller;
    }

	/**
	 *
	 * @return	string
	 */
    public function getControllerFileName()
    {
        return $this->controllerFile;
    }

	/**
	 *
	 * @param	string	$target
	 * @param	boolean	$isExternal
	 * @return	void
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     * </ol>
	 */
	public function redirect($target, $isExternal=FALSE)
	{
	
	}
	
	/**
	 *
     *
	 * @param	string	$className
	 * @param	string	$methodName
	 * @param	array	$segments
     * @param   array   $queryString
	 * @return	string
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     * </ol>
	 */
	public function recostructUrl
		($className = NULL,
         $methodName = NULL,
         array $segments = NULL,
         array $queryString = NULL)
	{
	
	}
	
    /**
     *
     *
     *
     * @return  integer
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     * </ol>
     */
	public function totalSegments()
	{
	
	}
	
    /**
     *
     *
     * @param   integer $n
     * @return  string|NULL
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     * </ol>
     */
	public function segment($n)
	{
	
	}

    /**
     *
     *
     *
     * @return  array
     * @todo
     * <ol>
     *  <li>Υλοποίηση.</li>
     * </ol>
     */
    public function segmentsAsArray()
    {

    }

    /**
     *
     *
     * @param   string  $offset
     * @return  mixed
	 * @todo
	 * <ol>
	 *  <li>Πιθανή αλλαγή ονόματος.</li>
	 * </ol>
     */
    public function getQueryString($offset)
    {
        if ($this->queryElems!=NULL)
            if (array_key_exists($offset, $this->queryElems))
                return $this->queryElems[$offset];
            else
                return NULL;
    }

    /**
     *
     *
     * @return  string
	 * @todo
	 * <ol>
	 *  <li>Πιθανή αλλαγή ονόματος.</li>
	 *  <li>Επανέλεγχος σύνθεσης της συμβολοσειράς.</li>
	 * </ol>
     */
    public function getQueryStringAsString()
    {
        if ($this->queryElems!=NULL) {
            $str = NULL;
        
            foreach($this->queryElems as $Var => $Val)
                $str .= $Var . " = " . $Val . ",";

			if ($str{strlen($str)-1}==",")
				$str{strlen($str)-1} = " ";

            return $str;
        } else 
            return NULL;
    }

}

?>
