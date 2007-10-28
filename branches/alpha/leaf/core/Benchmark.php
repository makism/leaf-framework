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
 *
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright	-
 * @license		-
 * @version		1.0-dev
 * @since		1.0-dev
 * @link		http://www.php.net/~helly/php/ext/spl/interfaceArrayAccess.html
 * @todo
 * <ol>
 *  <li>Υλοποίηση.</li>
 * </ol>
 */
final class leaf_Benchmark extends leaf_Base {
    
    const LEAF_REG_KEY = "benchmark";
    
    const LEAF_CLASS_ID = "LEAF_BENCHMARK-1_0_dev";

    /**
     *
     *
     *
     * @var array   $indexTable
     */
    private $indexTable = array();


    /**
     *
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);

        dependsOptOn("xdebug");
    }

    /**
     *
     *
     * @param   string  $name
     * @param   integer $type
     * @return  void
     */
    public function addIndex($name, $type)
    {

    }

}

?>
