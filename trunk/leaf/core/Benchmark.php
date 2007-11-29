<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Keeps statistics (execution time, memory usage) either for a 
 * specific class, or a code block.
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
final class leaf_Benchmark extends leaf_Base {
    
    const LEAF_REG_KEY = "Benchmark";
    
    const LEAF_CLASS_ID = "LEAF_BENCHMARK-1_0_dev";

    /**
     * All requested benchmark points are stored in this array, in
     * a hashtable-like way.
     *
     * @var array   $indexTable
     */
    private $indexTable = array();


    /**
     * Declares dependacies.
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);

        dependsOptOn("xdebug");
    }

    /**
     * Add a begin/end benchmark point.
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
