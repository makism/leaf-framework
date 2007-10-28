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
 * @subpackage  core.cache.backend
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @filesource
 */


/**
 * Μηχανισμός cache, βασιζόμενος στο πακέτο Apc
 * {@link http://pear.php.net/packages/apc}.
 *
 * @package		leaf
 * @subpackage	core.cache.backend
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @version		1.0-dev
 * @since		1.0-dev
 * @todo
 * <ol>
 *  <li>Υλοποίηση.</li>
 * </ol>
 */
 class leaf_Cache_Backend_Apc extends leaf_Cache {
	
	/**
     *
	 * @return void
	 */
	public function __construct()
	{
        dependsOn('apc');
        /*$r = apc_fetch($key);
        $r = apc_store($key, $data, ttl);
        apc_delete($key);*/
	}

}

?>
