<?php

/**
 * 
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @package		extensions
 * @subpackage	leaf
 */
class Xss extends leaf_Extension {
    
    protected $configFile = "xss.php";
	
    
	public function filter()
	{
		$args = func_get_args();
		$total= func_num_args();
		
		for($i=0; $i<$total; $i++) {
			$arg = $args[$i];
			
			/*$this->filterSql($arg);
			$this->filterHtml($arg);
			$this->filterOther($arg);*/
		}
		
		return $args[0];
	}
	
    public function init()
	{
        return NULL;
    }
    
    public function depends()
	{
        return NULL;
    }
	
	public function __toString()
	{
		return "Cross-site script (XSS) filter";
	}
	
	public function handle_pkg_classes()
	{
		return NULL;
	}
    
}

