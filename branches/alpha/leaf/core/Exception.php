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
 * Exception Class
 *
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @link		http://php.net/manual/en/language.exceptions.html
 * @todo
 * <ol>
 *  <li>Πιθανή εσωτερική υποστήριξη καταγραφής των εξαιρέσεων.</li>
 * </ol>
 */
final class leaf_Exception extends Exception {
    
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

}

?>
