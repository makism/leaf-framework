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
 * @subpackage  leaf.cache.backends
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version     $Id$
 */
class Cache_Backend_File extends Cache_Frontend {

    /**
     * 
     *
     * @var string
     */
    private $baseGroupDir = NULL;
    
    /**
     * 
     *
     * @var string
     */
    private $baseOrphansDir = NULL;
    
    /**
     * 
     * 
     *
     * @var string
     */
    private $namingHash = NULL;
    
    /**
     * 
     * 
     * @var string
     */
    private $securityHash = NULL;
    
    /**
     * 
     * 
     * @var string
     */
    private $filename = NULL;
    
    /**
     * 
     * 
     *
     * @var string
     */
    private $group = NULL;
    
    /**
     * 
     * 
     *
     * @var integer
     */
    private $ttl = NULL;
    
    /**
     * 
     * 
     * @var integer
     */
    private $expires = NULL;
    
    /**
     * 
     *
     * @var string
     */
    private $hash = NULL;
    
    /**
     * 
     * 
     *
     * @var string
     */
    private $key = NULL;
    
    /**
     * 
     * 
     * @var resource
     */
    private $fp = NULL;
    
    /**
     * 
     * @param   array   $options
     * @return  void
     */
    public function __construct(array $options)
    {
        parent::__construct($options);
        
        $this->baseGroupDir   = LEAF_VAR . 'cache/_groups/';
        $this->baseOrphansDir = LEAF_VAR . 'cache/_orphans/';
        
        
        if (($nameHash=$this->getSetting("nameHash"))!=NULL) {
            if (!in_array($nameHash, array("crc32", "md5", "sha1"))) {
                throw new leaf_Exception("asdfsd", 34534);
            }else {
                $this->namingHash = $nameHash;
            }
        } else {
            $this->namingHash = "sha1";
        }
        
        if (($secHash=$this->getSetting("securityHash"))!=NULL) {
            if (!in_array($secHash, array("crc32", "md5", "sha1", "strlen"))) {
                throw new leaf_Exception("sdfasfas", 459238);
            } else {
                $this->securityHash = $secHash;
            }
        } else {
            $this->securityHash = "sha1";
        }
        
    }
    
    /**
     * 
     * 
     *
     * @return  void
     */
    public function clearData()
    {
        $this->filename = NULL;
        $this->group= NULL;
        $this->hash = NULL;
        $this->ttl  = NULL;
        $this->expires = NULL;
        $this->key  = NULL;
        $this->data = NULL;
        
        if ($this->fp!=NULL) {
            fclose($this->fp);
            $this->fp = NULL;
        }
        
    }
    
    public function get()
    {
        $this->clearData();
        
        $args = func_get_args();
        $total= func_num_args();
        
        if ($total>=1) {
            $filename = NULL;
            $group    = $this->getSetting("group");
            
            $filename = $args[0];
            
            if ($total==2)
                $this->group = $args[1];
            
            if ($this->group!=NULL) {
                $tmp_group= $this->baseGroupDir . "/" . $this->group;
                
            } else if ($defaultGroup=$this->getSetting("group")) {
                $tmp_group = $this->baseGroupDir . $defaultGroup . "/";
                 
            } else {
                $tmp_group = $this->baseOrphansDir;
                
            }
            
            $this->key = $filename;
            $this->filename = "c_" . sha1($this->key);
            $tmp_file = $tmp_group . "/" . $this->filename;
            
            if (file_exists($tmp_file)) {
                if (filesize($tmp_file)>0) {
                    $this->fp = fopen($tmp_file, "rb");
                    
                    // read ttl
                    $this->ttl     = (int)trim(fread($this->fp, 11));
                    $this->expires = filemtime($tmp_file) + $this->ttl;
                    
                    // oldie, let`s delete it...
                    if ((time()-filemtime($tmp_file))>$this->ttl) {
                        fclose($this->fp);
                        @unlink($tmp_file);
                        return NULL;
                    }

                    // get hash?
                    if ($this->getSetting("calculateHash")==TRUE) {
                        $this->hash = trim(fread($this->fp, 40));
                    }
                    
                    // read data
                    $this->data = fread($this->fp, filesize($tmp_file));
                    
                    fclose($this->fp);

                    if ($this->getSetting("autoSerialize")==TRUE)
                        $this->data = unserialize($this->data);
                    
                    if (isset($hash))
                        if ($this->verify()==FALSE)
                            return FALSE;
                    
                    return $this->data;
                } else {
                    return NULL;
                    
                }
            }
        }
            
        return NULL;
    }
    
    public function store()
    {
        if ($this->isEnabled==FALSE)
            return FALSE;
        
        $this->clearData();
            
        $args = func_get_args();
        $total= func_num_args();
        
        if ($total>=2) {
            /*$filename = NULL;
            $group    = $this->getSetting("group");
            $var      = NULL;
            $ttl      = $this->getSetting("ttl");*/
            
            $this->group= $this->getSetting("group");
            $this->ttl  = $this->getSetting("ttl");
            
            $filename = $args[0];
            if ($total==4) {
                $this->group = $args[1];
                $var         = $args[2];
                $this->ttl   = $args[3];
            } else if ($total==3) {
                if (is_numeric($args[2])) {
                    $var       = $args[1];
                    $this->ttl = $args[2];                    
                } else {
                    $this->group= $args[1];
                    $var        = $args[2];                    
                }
            } else if ($total==2) {
                $var = $args[1];
            }
            
            // Determine the TTL
            if ($this->ttl==NULL)
                throw new leaf_Exception("asfsd", 3235);

            // Determine expire date
            $this->expires = time()+$this->ttl;
            
            if ($this->getSetting("autoSerialize")==TRUE)
                $var = serialize($var);
            
            // Does it belong to a Group?
            if ($this->group!=NULL) {
                $tmp_group= $this->baseGroupDir . "/" . $this->group;
                
                if (!file_exists($tmp_group) || !is_writable($tmp_group))
                    if(mkdir($tmp_group, 700, TRUE)==FALSE)
                        throw new leaf_Exception("", 40404);
                
            } else if ($defaultGroup=$this->getSetting("group")) {
                $tmp_group = $this->baseGroupDir . $defaultGroup . "/";
            
            // Or is it Orphan? :P
            } else {
                $tmp_group = $this->baseOrphansDir;
            }
            
            $tmp_file = $tmp_group . "/c_" . sha1($filename);
            
            if (file_exists($tmp_file))
                return FALSE;
            
            $fp = fopen($tmp_file, "wb");
            
            if(flock($fp, LOCK_EX + LOCK_NB)===TRUE) {
                // write ttl information
                fwrite($fp, sprintf("% 11d", $this->ttl), 11);
                
                // write a hash
                if ($this->getSetting("calculateHash")==TRUE) {
                    $this->hash = sha1($var);
                    fwrite($fp, sprintf("% 40s", $this->hash), 40);
                }
                
                $result = fwrite($fp, $var);
                @fclose($fp);
                
                clearstatcache();
                
                return TRUE;
                
            } else {
                return FALSE;
                
            }
            
        }
        
        return FALSE;
        
    }
    
    public function extendLife()
    {
        # touch();
    }
    
    public function ttl()
    {
        return $this->ttl;
    }
    
    public function expires()
    {
        return $this->expires;
    }
    
    public function truncate()
    {
        
    }
    
    public function verify()
    {
        return sha1($this->data)==$this->hash;
    }
    
    public function data()
    {
        return $this->data;
    }
    
    public function stored()
    {
        
    }
}
