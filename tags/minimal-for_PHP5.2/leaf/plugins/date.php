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
 * @subpackage  plugins
 * @author		Avraam Marimpis <makism@users.sourceforge.net>
 * @version     SVN: $Id$
 * @filesource
 */

use leaf::Base;

 
/**
 * @param	integer	$from
 * @param	integer	$to
 * @return	string|NULL
 * @todo
 *  <ol>
 *   <li>Possible rewrite the "previous week" code, taking into consideration
 *   the day of the week?</li>
 *  </ol>
 */
function period ($from, $to=NULL)
{
	static $l;
	
	if ($l==NULL)
		$l = Base::fetch("Locale");
	
	if ($to==NULL)
		$to = time();
		
	if ($from>=$to)
		return NULL;
	
	$t['year'] = date("Y", $to);
	$t['month']= date("n", $to);
	$t['day'] = date("j", $to);
	$t['hour'] = date("H", $to);
	$t['mins'] = date("i", $to);
	
	$f['year'] = date("Y", $from);
	$f['month']= date("n", $from);
	$f['day'] = date("j", $from);
	$f['hour'] = date("H", $from);
	$f['mins'] = date("i", $from);
	
	$returnStr = NULL;
	
	/****************************
	 * Same year and same month *
	 ****************************/
	if ($t['year'] == $f['year'] &&
		$t['month']== $f['month'])
	{
		$t['days'] = date("t", $to);
		$f['days'] = date("t", $from);
		
		$t['day_in_week'] = date("w", $to);
		$f['day_in_week'] = date("w", $from);
		
		$dayDiff = $t['day']-$f['day'];
		
		//
		// Today
		//
		if ($dayDiff==0) {
			//
			// Minutes
			//
			if (($t['hour']-$f['hour'])<=1) {
				if ($t['mins']==0)
					$t['mins']=60;
				
				if ($f['mins']>$t['mins']) {
					return sprintf(
								$l->getDate("Ago"),
								$f['mins']-$t['mins'],
								$l->getDate("Minutes")
					);
					
				} else if ($f['mins']<$t['mins']) {
					return sprintf(
								$l->getDate("Ago"),
								$t['mins']-$f['mins'],
								$l->getDate("Minutes")
					);
					
				} else {
					return $l->getDate("JustNow");
					
				}
				
			//
			// Hours
			//
			} else {
				return sprintf(
							$l->getDate("Ago"),
							$t['hour']-$f['hour'],
							$l->getDate("Hours")
				);
				
			}
			
			return;
			
		//
		// Yesterday
		//
		} else if ($dayDiff==1) {
			$returnStr = $l->getDate("Yesterday");
			
		//
		// Couple days ago (specific day name)
		//
		} else if ($dayDiff>1 && $dayDiff<7) {
			$returnStr = $l->getDate("FullDays", date("w", $from)+1);
			
		//
		// Some previous week...
		//
		} else if ($dayDiff>=7) {
			$res = floor(($dayDiff)/7);
			
			if ($res==1) {
				return $l->getDate("AWeekAgo");
			} else {
				return sprintf(
						$l->getDate("Ago"),
						$res,
						$l->getDate("Weeks")
				);
			}
			
			return;
		}
		
		$returnStr .= " ";
		
		//
		// Calculate time of date, evening, afternoon, morning, midnight...
		//
		if ($f['hour']>=6 && $f['hour']<=12)
			$returnStr .= $l->getDate("Morning");
			
		else if ($f['hour']>=12 && $f['hour']<=16)
			$returnStr .= $l->getDate("Evening");
			
		else if ($f['hour']>=16 && $f['hour']<=20)
			$returnStr .= $l->getDate("Afternoon");
			
		else if ($f['hour']>=20 && $f['hour']<=23)
			$returnStr .= $l->getDate("Night");
			
		else if ($f['hour']>=0 && $f['hour']<=6)
			$returnStr .= $l->getDate("Midnight");
		
		return $returnStr;
	/****************************
	 * Same year                *
	 ****************************/
	} else if ($t['year']==$f['year']) {
		if ($t['month']-$f['month']==1) {
			return $l->getDate("PreviousMonth");
			
		} else {
			return sprintf (
						$l->getDate("DayAtMonth"),
						date("j", $from),
						$l->getDate("FullMonths2", date("n", $from))
			);
		}
		
	/****************************
	 * Some day...              *
	 ****************************/
	} else {
		if ($t['year']-$f['year']==1) {
			return $l->getDate("FullMonths", date("n", $from)) . ", " . $l->getDate("LastYear");
			
		} else {
			return $l->getDate("FullMonths", date("n", $from)) . ", " . date("Y", $from);
			
		}
	}

}
