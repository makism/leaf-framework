<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 */

namespace leaf::Base;


/**
 * Provides a simple method to handle multiple locales. Only one can be used at a time.
 * 
 * Also handles the translation of all leaf`s messages, the timezone etc.
 *
 * @package     leaf
 * @subpackage  core
 * @author  	Avraam Marimpis <makism@users.sourceforge.net>
 * @version	    SVN: $Id$
 */
final class Locale extends Base {

	/**
	 * The current locale`s name.
	 *
	 * @var string
	 */
	private $locale = NULL;
	
	/**
	 * All the translation strings.
	 *
	 * @var	array
	 */
	private $strings = NULL;


	/**
	 * Registers Locale, and loads the translations.
	 *
	 * @return  void
	 */
	public function __construct()
	{
		parent::__construct("Locale", $this);
		require_once LEAF_BASE . "base/helpers/Locale.php";
		
		$this->locale = $this->Config['locale'];
		
		require_once LEAF_BASE . "locale/{$this->locale}/error.php";
		require_once LEAF_BASE . "locale/{$this->locale}/messages.php";
		require_once LEAF_BASE . "locale/{$this->locale}/general.php";
		require_once LEAF_BASE . "locale/{$this->locale}/date.php";
		
		$this->strings['general'] = $general;
		$this->strings['date']	  = $date;
		$this->strings['messages']= $messages;
		$this->strings['error']	  = $error;
		
		unset($general, $date, $leaf);
	}
	
	/** 
	 * Loads a user-defined translation file into the internal array.
	 *
	 * @param	string	$file
	 * @return	void
	 */
	public function loadFile($file)
	{
		$completeFile = LEAF_BASE . "locale/{$this->locale}/{$file}.php";
		
		if (file_exists($completeFile)) {
			if (in_array($completeFile, get_included_files())==FALSE) {
				require_once $completeFile;
				
				$this->strings[$file] = $file;
			}
		}
	}
	
	/**
	 * Magic method which allow dynamic method naming.
	 * 
	 * In simpler terms, this means that you can fetch the contents
	 * of a translation array or even a string by calling a method like:
	 * <code>getGeneral($str)</code>
	 * This will return the offset "$str", from the translation array "general".
	 *
	 * @param	string	$method
	 * @param	array	$args
	 * @return	mixed
	 */
	public function __call($method, $args)
	{
		$match = "@^get(?P<l>[A-Z]{1}.+)$@";
		$size  = sizeof($args);
		
		if (preg_match($match, $method, $hits)) {
			$offset = strtolower($hits['l']);
			
			if (array_key_exists($offset, $this->strings)) {
				if (array_key_exists($offset, $this->strings)) {
					if (array_key_exists($args[0], $this->strings[$offset])) {
						if ($size==1) {
							return $this->strings[$offset][$args[0]];
						} else if ($size==2) {
							return $this->strings[$offset][$args[0]][$args[1]];
						}
					}
				}
			}
			
		}
		
		return NULL;
	}
	
	public function __toString()
	{
	    
	}

}
