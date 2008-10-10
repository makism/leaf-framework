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
abstract class Cache_Frontend {
    
    /**
     * 
     * 
     * @var array
     */
    protected $options = NULL;
    
    /**
     * 
     * 
     * @var boolean
     */
    protected $isEnabled = NULL;
    
    /**
     * 
     * 
     * @var integer
     */
    protected $cacheHits = NULL;
    
    /**
     * 
     * 
     * @var integere
     */
    protected $cacheMisses = NULL;
    
    
    /**
     * 
     * 
     *
     * @param   array   $options
     * @return  void
     */
    public function __construct(array $options)
    {
        $this->options    = $options;
        $this->isEnabled  = TRUE;
        $this->cacheHits  = 0;
        $this->cacheMisses= 0;
    }
    
    /**
     * 
     * 
     * @param   string  $setting
     * @return  mixed
     */
    public function getSetting($setting)
    {
        if (array_key_exists($setting, $this->options))
            return $this->options[$setting];
    }
    
    /**
     * 
     * 
     * 
     * @return  void
     */
    public function disable()
    {
        $this->isEnabled = FALSE;
    }
    
    
    /**
     *
     * 
     * @return  void
     */
    public function enable()
    {
        $this->isEnabled = TRUE;
    }
    
    /**
     * 
     * 
     *
     */
    abstract public function get();
    
    /**
     *
     *
     * 
     */
    abstract public function store();
    
    /**
     * 
     * 
     * @return  boolean
     */
    abstract public function stored();
    
    /**
     * 
     * 
     * @return  boolean
     */
    abstract public function extendLife();
    
    /**
     * 
     * 
     * @return  integer
     */
    abstract public function ttl();
    
    /**
     * 
     * @return  integer
     */
    abstract public function expires();
    
    /**
     * 
     * 
     * @return  boolean 
     */
    abstract public function truncate();
    
    /**
     * 
     * 
     * @return  boolean
     */
    abstract public function verify();
    
    /**
     * 
     * 
     * @return  mixed
     */
    abstract public function data();
    
}
