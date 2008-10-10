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
 *
 *
 * @package     extensions
 * @subpackage  leaf.cache
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     $Id$
 */
class Cache extends leaf_Extension {
    
    protected $configFile = "cache.php";
    
    private $frontend = NULL;
    
    private $backends = array ("File");
    

    public function init()
    {
        $driver = ucfirst($this->configurationOptions['backend']);
        
        if (in_array($driver, $this->backends)) {
            $tmp = "Cache_Backend_" . $driver;
            $this->frontend = new $tmp($this->configurationOptions);
        } else {
            throw new leaf_Exception("asf", 45234);
        }
        
    }
    
    public function handle_pkg_classes()
    {
        require_once $this->extensionBaseDir . "Cache.php";
        require_once $this->extensionBaseDir . "Cache_Frontend.php";
        require_once $this->extensionBaseDir . "backends/File.php";
    }
    
    public function __call($method, $args)
    {
        if (is_callable(array($this->frontend, $method))) {
            return call_user_func_array(array($this->frontend, $method), $args);
        }
    }
    
    public function __toString()
    {
         
    }
    
}
