<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/licence/  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  plugins
 * @author      Marimpis Avraam <makism@users.sf.net>
 * @version     $Id$
 * @filesource
 */


/**
 * Computes and returns the difference from the given unix timestamp
 * to the current timestamp.
 * 
 * The result is something like this
 * <code>
 *  1 year, 3 months, 20 days, 1 hour, 3 seconds
 * </code>
 * 
 * @param   integer $to
 * @param   integer $from
 * @param   array   $fields
 * @return  string
 * @todo
 * <ol>
 *  <li>Add l18n support.</li>
 *  <li>Add support for returning only the specified fields defined in the
 *  array 'fields'.</li>
 * </ol>
 */
function period($to, $from=NULL, array $fields=NULL)
{
    // End of period date.
    $curr = ($from!=NULL) ? $from : time();
    
    // Return string.
    $str = NULL;

    // Auxialiary variables.
    $years = abs(date("Y", $curr) - date("Y", $to));
    $months= abs(date("n", $curr) - date("n", $to));
    $days  = abs(date("j", $curr) - date("j", $to));
    $hours = abs(date("G", $curr) - date("G", $to));
    $mins  = abs(date("i", $curr) - date("i", $to));
    $secs  = abs(date("s", $curr) - date("s", $to));
    
    // Years.
    if ($years>0) {
        $str .= $years;
        $str .= ($years>1) ? " years" : " year";
        
        if ($months>0)
            $str .= ", ";
    }
        
    // Months
    if ($months>0) {
        $str .= $months;
        $str .= ($months>1) ? " months" : " month";
        
        if ($days>0)
            $str .= ", ";
    }

    // Days    
    if ($days>0) {
        $str .= $days;
        $str .= ($days>1) ? " days" : " day";
        
        if ($hours>0)
            $str .= ", ";
    }
    
    // Hours
    if ($hours>0) {
        $str .= $hours;
        $str .= ($hours>1) ? " hours" : " hour";
        
        if ($mins>0)
            $str .= ", ";
    }
    
    // Minutes
    if ($mins>0) {
        $str .= $mins;
        $str .= ($mins>1) ? " minutes" : " minute";
        
        if ($secs>0)
            $str .= ", ";
    }
    
    // Seconds
    if ($secs>0) {
        $str .= $secs;
        $str .= ($secs>1) ? " seconds" : " second";
    }
    
    return $str;
}

?>
