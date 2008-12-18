<?php
/**
 * This source file is licensed under the New BSD license.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     http://leaf-framework.sourceforge.net/LICENSE  New BSD License
 * @link        http://leaf-framework.sourceforge.net
 *
 * @package     leaf
 * @subpackage  front.helpers
 * @author      Avraam Marimpis <makism@users.sourceforge.net>
 * @version		SVN: $Id$
 * @filesource
 */


/**
 * Returns the specified lines from a files.
 * 
 * This is used internally to present a code snippet that propably
 * contains errors.
 *
 * @param   string  $filename
 * @param   integer $startline
 * @param   integer $endline
 * @return  string
 */
function debug_parsefile($filename, $startline, $endline=-1)
{
    global $Config;

    $contents   = file($filename);
    $total_lines= sizeof($contents);
    $returnStr  = "";

    $beforeLines= 5;
    $afterLines = 5;
    $afterStr = NULL;
    $beforeStr= NULL;

    if ($total_lines-$startline>=5) {
        $afterLines = 5;
    } else {
        $afterLines = $total_lines-$startline;
    }

    if ($startline>=5) {
        $beforeLines = 5;
    } else {
        $beforeLines = $startline-5;
    }
    
    for ($i=$startline+1; $i<=$startline+$afterLines; $i++) {
        $tmp = $i . " " . $contents[$i];
        $afterStr .= $tmp;
    }

    for ($i=$startline-$beforeLines; $i<$startline; $i++) {
        $tmp = $i . " " . $contents[$i];
        $beforeStr .= $tmp;
    }


    $returnStr = $beforeStr;
    $returnStr .= "<span style=\"font-weight: bold; color: #ff0000;\">" . $startline . " " . $contents[$startline] . "</span>";
    $returnStr .= $afterStr;

    return $returnStr;
}
