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
 * Custom exception class.
 *
 * @package     leaf
 * @subpackage  core
 * @author		Avraam Marimpis <makism@users.sf.net>
 * @version		$Id$
 * @link		http://php.net/manual/en/language.exceptions.html
 * @todo
 * <ol>
 *  <li>Possible, internal logging function.</li>
 * </ol>
 */
final class leaf_Exception extends Exception {
    
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

}

?>
