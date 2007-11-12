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
 * Handles internal hashing procedures, based on already existing
 * native hash methods.
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @todo
 * <ol>
 *  <li>Possible creation of an interface.</li>
 * </ol>
 */
final class leaf_Hash {
	
	/**
     * Default hash algorithm
     *
     * @var string
     */
	private $defaultAlgorithm = "md5";
	
	/**
     * All supported hash algorithms.
     *
     * @var array
     */
	private $algorithms = array ("md5", "sha1");
	
	/**
     * Whether to use an alternative method or the classic hash functions.
     *
     * The alternative method, is based on the "hash" function that is
     * documented to be faster than the classic hash functions like
     * "sha1" and "md5".
     *
     * @var boolean
     */
	private $useAltMethod = FALSE;
	
	
	/**
     * Flags the method of hashing the we will be using.
     *
	 * @return void
	 */
	public function __construct()
	{
        if (dependsOptOn('hash'))
			$this->useAltMethod = TRUE;
	}
	
	/**
     * Sets the requested algorithm for usage.
     *
	 * @param	string	$algorithm
	 * @return	boolean
	 */
	public function setAlgorithm($algorithm)
	{
		if (in_array($algorithm, $this->available)) {
			$this->algorithm = $algorithm;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
     * Returns (as text or as a byte sequence) the hash for
     * the specific give input.
     *
	 * @param	string	$data
	 * @param	boolean	$raw
	 * @return	string
	 */
	public function digestMsg($data, $raw=FALSE)
	{
		if ($this->useAltMethod) {
			return hash($this->algorithm, $data, $raw);
		} else {
			return call_user_func($this->algorithm, $data, $raw);
		}
	}
	
	/**
     * Returns (as text or as a byte sequence) the hash for
     * the specific file`s contents.
	 *
	 * @param	string	$filename
     * @param   boolean $raw
	 * @return	string
	 */
	public function digestFile($filename, $raw=FALSE)
	{
        if (file_exists($filename) && is_readable($filename)) {
    		if ($this->useAltMethod) {
    			return hash_file($this-algorithm, $filename, $raw);
    		} else {
    			return call_user_func($this->algorithm . "_file", $filename, $raw);
    		}
        } else {
            throw new leaf_Exception('file access failed');
        }
	}

}

?>
