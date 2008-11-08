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

namespace leaf\Front\Helpers;
use leaf\Base as Base;
use leaf\Core\Helpers as cHelpers;


/**
 * Presents a "Page Not Found" message.
 * 
 * @param   string  $str
 * @return  void
 * @todo
 * <ol>
 *  <li>Implement.</li>
 * </ol>
 */
function showErrorPage404($str=NULL)
{
    die();
}

/**
 * Prints styled text. Used in printing debug messages and errors.
 * 
 * @param   string  $title
 * @param   string  $str
 * @param   boolean $die
 * @return  void
 */
function showHtmlMessage($title, $reason, $die=FALSE)
{

$errorMsg = Base\Base::fetch("Locale")->getError('ErrorOccured');
$image    = cHelpers\baseUrl() . "content/leaf/error.png";

echo <<<ERROR_MSG
    <br />
    <br />
    <div style="margin: 0px auto; width: 600px; overflow: hidden;">
        <div style="font-size: 16px; background-color: #f7f7da; padding: 5px;">
            <img src="$image" style="vertical-align: middle;"/>
            $errorMsg
        </div>

        <div style="margin: 5px 0px 0px 0px; border: 1px solid #f0f0f0; padding: 10px;">
            <span><b>$title</b></span>
            <br />
            <span>$reason</span>
        </div>

    </div>
    <br />
    <br />
ERROR_MSG;

    if ($die)
        die();
}


