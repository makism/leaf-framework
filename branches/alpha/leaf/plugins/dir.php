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
 * @subpackage	plugins
 * @author		Avraam Marimpis <makism@venus.cs.teicrete.gr>
 * @copyright		-
 * @license		-
 * @filesource
 */


/**
 * unixize_path
 *
 *
 * @param	string	$path
 * @return	string
 */
function unixize_path($path, $performCheck = FALSE)
{
	if ($performCheck) {
		$hits = preg_match("@\\\@", $path);
		
		if ($hits==0)
			return $path;
	}

	return preg_replace("@\\\@", "/", $path);
}

/**
 * rev_unixize_path
 *
 * @param	string	$path
 * @return	string
 */
function rev_unixize_path($path, $performCheck = FALSE)
{
	if ($performCheck) {
		$hits = preg_match("@/@", $path);
		
		if ($hits==0)
			return $path;
	}

	return preg_replace("@/@", "\\", $path);
}

/**
 * truncate_slashes

 *
 * @param	string	$path
 * @return	string
 */
function truncate_slashes($path, $leading=TRUE, $trailing=TRUE)
{

}

/**
 * truncate_backslashes
 *
 * @param	string	$path
 * @return	string
 */
function truncate_backslashes($path, $leading=TRUE, $trailing=TRUE)
{
	
}

?>
