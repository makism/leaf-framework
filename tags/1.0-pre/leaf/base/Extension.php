<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */


/**
 * Provides a common behaviour for all extensions.
 *
 * @package     leaf
 * @subpackage  base
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 */
abstract class leaf_Extension extends leaf_Base {    
    
    /**
     * An optional configuration file that is to be loaded.
     *
     * @var string
     */
    protected $configFile = NULL;
	
	/**
	 * Extension`s base directory (in which the other package classes reside).
	 *
	 * @var string
	 */
	protected $extensionBaseDir = NULL;
	
	/**
	 * Extension`s unique id name.
	 *
	 * @var	string
	 */
	protected $extensionId = NULL;
    
    /**
     * Extension`s configuration options.
     * 
     * @var	array
     */
    protected $configurationOptions = array(); 
	
	
	/**
	 * Registers the extension and decides how the pakackage`s classes will be handled.
	 *
	 * @param  string  $baseId
	 * @param  string  $baseDir
	 * @return void
	 */
	public function __construct($baseId, $baseDir=NULL)
	{
		$this->extensionId = $baseId;
		
		if ($baseDir!=NULL) {
			$this->extensionBaseDir = str_replace("//", "/", $baseDir . "/");
		}
		
		$this->handle_pkg_classes();
		
		/*if ($this->handle_pkg_classes()==NULL) {
			$this->autohandle_pkg_classes();
		}*/
	}
    
    
    /**
     * Parses-loads an extension`s configuration file (if any).
     *
     * @return	NULL
     */
    public function parseConfig()
    {
        if ($this->configFile!=NULL) {
            $completeFile = LEAF_BASE . 'etc/extensions/' . $this->configFile;
			
            if (file_exists($completeFile) && is_readable($completeFile)) {
                require $completeFile;
                
                $this->configurationOptions = $config;
                
                unset($config);
            }
        }
    }
	
    /**
     * The first (userspace) method executed when an extension is loaded.
     *
     * @return  void
     */
    abstract public function init();

	/**
	 * User-defined method for including a package`s files.
	 *
	 * @return	void
	 */
	abstract public function handle_pkg_classes();
	
	/**
	 * Handles automatically the inclusion of a package`s files.
	 * 
	 * This is done by crawling a package`s contents and including
	 * one by one the files.
	 *
	 * @return	void
	 * @todo
	 * <ul>
	 *     <li>Inject these files to the "__autoload" function to allow
	 *     on-demand file inclusion.</li>
	 * </ul>
	 */
	private function autohandle_pkg_classes()
	{
		
	}
	
	/**
	 *
	 * @return string
	 */
	public function __toString()
	{
	    return "Extension:" . $this->extensionId;
	}

}

