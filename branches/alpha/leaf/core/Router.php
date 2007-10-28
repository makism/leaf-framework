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
 * Επεξεργάζεται και φιλτράρει, το Uri για το τι πρέπει να γίνει.
 *
 * Ανακαλύπτει ποιον Controller θα πρέπει να εκτελέσουμε και
 * ποια μέθοδο (αν έχει οριστεί). Επιπλέον φιλτράρει το Uri
 * για χαρακτήρες που θα πρέπει να βρίσκονται εκεί και αποσπά
 * το Query String όταν χρειάζεται και εάν έχει ενεργοποιηθεί.
 *
 *
 * @package		leaf
 * @subpackage	core
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Μήπως {@link leaf_Router αυτή η κλάση} να αναλάβει και τις λειτουργίες της κλάσης
 *  {@link leaf_Request};</li>
 *  <li>Παροχή μίας εναλλακτικής κλάσης (που πιθανόν, θα κληρονομεί από αυτήν)
 *      που θα χρησιμοποιεί στατικούς κανόνες δρομολόγησης.</li>
 * </ol>
 */
final class leaf_Router extends leaf_Base {

    const LEAF_REG_KEY = "router";
    
    const LEAF_CLASS_ID = "LEAF_ROUTER-1_0_dev";


	/**
     *
     *
     * @var string
     */
	private $requestUri = NULL;
	
	/**
     *
     *
     * @var string
     */
	private $requestClass = NULL;
	
	/**
     *
     *
     * @var string
     */
	private	$requestMethod= NULL;
	
	/**
     *
     *
     * @var array
     */
	private $segments = NULL;
	
	/**
     *
     *
     * @var string
     */
	private $queryString = NULL;
	
	/**
     *
     *
     * @var array
     */
	private $queryStringElements = NULL;

	
	/**
     * Ελληνική μετάφραση πάει εδώ...
	 *
	 * @see		leaf_Config
	 * @see		leaf_Request
	 * @return	void
     * @todo
     * <ol>
     *  <li>"Σπάσιμο" των εργασιών που επιτέλει ο constructor σε επιμέρους μεθόδους.</li>
     *  <li>Επανέλεγχος της λειτουργίας σχετικά με το επέκταση που μπορεί να
     *      υπάρξει στο Uri.</li>
     * </ol>
	 */
	public function __construct() {
        
        parent::__construct(self::LEAF_REG_KEY);
	    
		$this->requestUri   = $_SERVER['REQUEST_URI'];

        /*
         * Αντικατάσταση των πιθανών συνεχόμενων /, με ένα μόνο.
         */
        $this->requestUri = preg_replace("@/+@i", "/", $this->requestUri);
        
		/*
		 * We check if there are any illegal characters in
		 * the Uri that they shouldn`t.
		 * Moreover, we take into consideration if the option
		 * $this->config['url_suffix'] is used which defines the file
		 * extensions that will be shown, so we ignore it.
         *
         *
		 */
		/*$skipExt = (!empty($this->config['url_suffix']))
					? "(\.[^?=&]+)?"
					: "";*/
        $skipExt = "";
			
		$skipQueryString = ($this->config['allow_query_strings']=="Yes")
			? "(\?(["
				. $this->config['allow_query_string_chars']
				. "]+(=["
				. $this->config['allow_query_string_chars']
				. "]*)?\&?)+)?"
			: "";
			
		$checkUri = preg_match_all(
			"|"
				. "^[" . preg_quote($this->config['allow_uri_chars']) . "]+"
				. "{$skipExt}{$skipQueryString}$" .
			"|iu",
			$this->requestUri,
			$hits
		);
		
		if ($checkUri==0) {
		    /*$this->logger->log(
		        "Error",
		        "Routing Error, Malicious characters found in Uri ("
		        . "{$this->requestUri})"
		    );*/
		    
			showHtmlMessage(
			    "Routing Error",
			    "Malicious characters found in Uri!",
			    true
			);
		}
		
		/*
		 * We check if there is a query string in our uri.
		 * If query strings are enable in file
		 * (Etc/config.php - parameter $config['allow_query_strings']),
		 * we process it in an associative array way.
		 * Either way, we remove the query string from the
		 * request uri.
         *
         *
		 */
		if (preg_match("@\?(.+(=.+)?\&?$)+@iu", $this->requestUri, $matches)) {
            
			if ($this->config['allow_query_strings']=="Yes") {
                
				$this->queryString = $matches[0];

				$keysWithValues = explode("&", $matches[1]);

				foreach ($keysWithValues as $Elem) {

                    if (strpos($Elem, "=")) {
            			list($Key, $Value) = explode("=", $Elem);                
            			$this->queryStringElements[$Key] = $Value;
                    } else {
                        $this->queryStringElements[$Elem] = NULL;
                    }
				}
                
				$this->requestUri = preg_replace(
					"|"
						. preg_quote($this->queryString) .
					"|iu",
					"",
					$this->requestUri
				);
                
			} else {
				$this->requestUri = preg_replace(
					"|" . preg_quote($matches[0]) . "|i",
					"",
					$this->requestUri
				);
			}
		}

		
		/*
		 * Removal of leading base dir.
         *
         *
		 */
		$this->requestUri = preg_replace(
			"@^{$this->config['base_dir']}@",
			"",
			$this->requestUri
		);
		
		/*
		 * Removal of the url trailing if defined.
         *
         *
		 */
		if (!empty($this->config['url_suffix']))
			$this->requestUri = preg_replace(
				"@\.{$this->config['url_suffix']}/?$@",
				"",
				$this->requestUri
			);
		
		/*
		 * Removal of trailing '/' (if exists in Uri).
         *
         *
		 */
		if (preg_match("@/$@", $this->requestUri))
			$this->requestUri = preg_replace("@/$@", "", $this->requestUri);

		/*
		 * If no class is defined instatiate the default Controller.
         *
         *
		 */
		if ($this->requestUri=="/"	||
			$this->requestUri==NULL	||
			($this->requestUri{0}=="?" && $this->config['allow_query_strings']=="Yes"))
			$this->requestClass = $this->config['default_controller'];
			
		/*
		 * We extract the Controller class (if defined).
         *
         *
		 */
		else
			$this->chopSegment($this->requestClass);
		
		/*
		 * We extract the method (if defined).
         *
         *
		 */
		$this->chopSegment($this->requestMethod);
		if ($this->requestMethod==NULL)
		    $this->requestMethod = "index";
		
		/*
		 * If there are more segments in the Uri, except from the
		 * class name and the method name, we store those segments
		 * in an array and we provide them at the user`s disposal.
         *
         *
         *
		 */
		$segments = explode("/", $this->requestUri);
		foreach ($segments as $s) {
			if ($s!=null)
				$this->segments[] = $s;
		}
		
	}

    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

    /**
     * Επιστρέφει έναν πίνακα με τα στοιχεία του Query String.
     * 
     * @see     leaf_Request
     * @return  array|NULL
     */
    public function queryStringElements()
    {
        return $this->queryStringElements;
    }
	
	/**
     * Επιστρέφει το συνολικό αριθμό των κομματιών.
	 *
	 * @return	integer
	 */
	public function segmentsSize()
	{
		return sizeof($this->segments);
	}
	
	/**
     * Επιστρέφει έναν πίνακα με τα επιπλέον στοιχεία στο Uri
     * (εκτός της κλάσης, της μεθόδου και του query string).
	 *
     * @see     leaf_Request
	 * @return	array|NULL
	 */
	public function segments()
	{
		return $this->segments;
	}

	/**
     * Αφαιρεί την πρώτη συμβολοσειρά που θα βρεθεί, μέχρι να τον
     * εντοπισμό του πρώτου χαρακτήρα '/' στο μέλος $this->requestUri.
	 *
	 * @param	string	$seg
	 * @return	void
	 */
	private function chopSegment(&$seg)
	{
		if ($this->requestUri!="") {
			if (preg_match("@([^/\?]*)@", $this->requestUri, $hits)) {
				$seg = $hits[0];
				$this->requestUri = preg_replace("@([^/\?]*/?)@", "", $this->requestUri, 1);
			}
		}
	}
	
	/**
     * Επιστρέφει το όνομα του Controller που θα εκτελέσουμε.
	 *
     * @see     leaf_Request
	 * @return  string
	 */
	public function getClassName()
	{
		return $this->requestClass;
	}
	
	/**
     * Επιστρέφει την μέθοδο του Controller που θα πρέπει να εκτελέσουμε.
     *
     * @see     leaf_Request
	 * @return  string
	 */
	public function getMethodName()
	{
		return $this->requestMethod;
	}

}

?>
