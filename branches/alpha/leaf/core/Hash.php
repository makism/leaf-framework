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
 * Επιτελεί λειτουργίες δημιουργίας συνόψεων.
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Πιθανή παροχή ενός interface.</li>
 * </ol>
 */
final class leaf_Hash {
	
	/**
     * Ο προεπιλεγμένος αλγόριθμος.
     *
     * @var string
     */
	private $defaultAlgorithm = "md5";
	
	/**
     * Όλοι οι διαθέσιμοι αλγόριθμοι.
     *
     * @var array
     */
	private $algorithms = array ("md5", "sha1");
	
	/**
     * 
     *
     * @var boolean
     */
	private $useAltMethod = FALSE;
	
	
	/**
	 * Σηματοδοτεί την χρήση ή όχι της μεθόδου hash,
     * έναντι των κλασσικών συναρτήσεων md5 και sha1.
     *
	 * @return void
	 */
	public function __construct()
	{
        if (dependsOptOn('hash'))
			$this->useAltMethod = TRUE;
	}
	
	/**
	 * Θέτει τον επιθυμητό αλγόριθμο προς χρήση.
     *
	 * @param	string	$algorithm
	 * @return	boolean
	 */
	public function setAlgorithm($algorithm)
	{
		if (in_array($algorithm, $this->available)) {
			$this->algorithm = $algorithm;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Επιστρέφει (είτε ώς κείμενο είτε ώς μία ακολουθία bytes)
     * την σύνοψη για το κείμενο που δίνεται.
     *
	 * @param	string	$data
	 * @param	boolean	$raw
	 * @return	string
	 */
	public function digestMsg($data, $raw=FALSE)
	{
		if ($this->useAltMethod) {
			return hash($this->algorithm, $data, $raw);
		} else {
			return call_user_func($this->algorithm, $data, $raw);
		}
	}
	
	/**
	 * Επιστρέφει (είτε ώς κείμενο είτε ώς μίας ακολουθία bytes)
     * την σύνοψη των περιεχομένων ενός αρχείου.
	 *
	 * @param	string	$filename
     * @param   boolean $raw
	 * @return	string
	 */
	public function digestFile($filename, $raw=FALSE)
	{
        if (file_exists($filename) && is_readable($filename)) {
    		if ($this->useAltMethod) {
    			return hash_file($this-algorithm, $filename, $raw);
    		} else {
    			return call_user_func($this->algorithm . "_file", $filename, $raw);
    		}
        } else {
            throw new leaf_Exception('file access failed');
        }
	}

}

?>
