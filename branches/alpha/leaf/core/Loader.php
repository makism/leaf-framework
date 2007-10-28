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
class leaf_Loader extends leaf_Base {

    const LEAF_REG_KEY = "loader";
    
    const LEAF_CLASS_ID = "LEAF_LOADER-1_0_dev";


    /**
     *
     *
     * @return  void
     */
    public function __construct()
    {
        parent::__construct(self::LEAF_REG_KEY);
    }


    public function __toString()
    {
        return __CLASS__ . " " . self::LEAF_CLASS_ID;
    }

    /**
     *
     *
     * @param   string  $modelName
     * @param   array   $opts
     * @return  void
     */
    public function model($modelName, $opts=NULL)
    {
    }

    /**
     *
     *
     * @param   string  $name
     * @return  void
     */
	public function library($name)
	{
		
	}
	
    /**
     *
     *
     * @param   string  $ext
     * @param   string  $namespace
     * @return  void
     */
	public function extension($ext, $namespace=NULL)
	{
	
	}

    /**
     *
     *
     * @param   string  $class
     * @return  void
     */
    public function endorsed($class)
    {

    }
	
    /**
     *
     * @param   string  $plugin
     * @return  void
     */
	public function plugin($plugin)
	{
	
	}

}

?>
