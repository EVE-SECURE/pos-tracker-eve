<?php
/**
 * Pos-Tracker2
 *
 * Starbase Cron Mail script
 *
 * PHP version 5
 *
 * LICENSE: This file is part of POS-Tracker2.
 * POS-Tracker2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * POS-Tracker2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with POS-Tracker2.  If not, see <http://www.gnu.org/licenses/>.
 *

 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @author      Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2007-2009 (C)  Stephen Gulick, DeTox MinRohim, and Andy Snowden
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    POS-Tracker2
 * @version    SVN: $Id$
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

include_once 'includes/class.posmailer.php';
$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eve     = New Eve();
$posmgmt = New POSMGMT();

$mail = new posMailer();
$mail->mailinit();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$access = 5;
$eve->SessionSetVar('access', $access);

$eveRender->Assign('access', $access);

	$args['pr'] = 2;
    $rows = $posmgmt->GetAllPos2($args);

    foreach($rows as $key => $row) {

        $row2 = $posmgmt->GetLastPosUpdate($row['pos_id']);
		
		$tower = $posmgmt->GetTowerInfo($row['pos_id']);
		
		if ($tower) {
		$tower['current_cpu']            = $tower['cpu'];
        $tower['current_pg']              = $tower['powergrid'];
		}
		
		$charters_needed         = $tower['charters_needed'];
		$pos_size                 = $row['pos_size'];
	    $pos_race                 = $row['pos_race'];
	    $systemID                 = $row['systemID'];
		$allianceid                = $row['allianceid'];
        $tower['sovfriendly']    = $posmgmt->getSovereigntyStatus($systemID, $allianceid);
		
		$row3 = $posmgmt->GetStaticFBTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size));
		
		if ($tower['sovfriendly'] == 1) {
			$tower['hasSov'] = .75;
		} else {
			$tower['hasSov'] = 1;
		}

		if ($row3) {
			$tower['required_fuelblock']         = ceil($row3['fuelblock'] * $tower['hasSov']);
            $tower['required_strontium']         = ceil($row3['strontium'] * $tower['hasSov']);
            $tower['required_charters']          = $charters_needed?1:0;
			$row3['charters']					= $tower['required_charters'];
            $tower['total_pg']                   = $row3['pg'];
            $tower['total_cpu']                  = $row3['cpu'];
            $tower['uptimecalc']                 = $posmgmt->uptimecalc($row['pos_id']);
            $tower['pos_capacity']=$tower['fuel_hangar']=$row3['fuel_hangar'];
        } 

		$row['result_uptimecalc']= $posmgmt->uptimecalc($row['pos_id']);
		$row['result_online']    = $posmgmt->online($row['result_uptimecalc']);
		$row['last_update']      = gmdate("Y-m-d H:i:s", $row2['datetime']);
		$row['online']           = $posmgmt->daycalc($row['result_online']);
		$row['region']           = $posmgmt->getRegionNameFromMoonID($row['MoonName']);
		$row['system']           = $posmgmt->getSystemName($row['systemID']);
		$row['result_optimal']   = $posmgmt->posoptimaluptime($tower);
		
        $rows[$key] = $row;
		$characterInfo=$posmgmt->GetUserInfofromID($row['owner_id']);
		$secondary_characterInfo=$posmgmt->GetUserInfofromID($row['secondary_owner_id']);

		$diff=array('fuelblock' => $row['result_optimal']['optimum_fuelblock']-$row['fuelblock'],
		'charters'=>$row['result_optimal']['optimum_charters']-$row['charters']);

		if($row['pos_status'] >=2) {
		
			if($characterInfo['away']!=1 && isset($characterInfo['email'])) {
				if($row['result_online']<$config['minimal_fuel']) {
					$mail->posalert($characterInfo['email'], $characterInfo['name'], $row, $row3, $diff);
				}
			}
			
			if($secondary_characterInfo['away']!=1 && isset($secondary_characterInfo['email'])) {
				if($row['result_online']<$config['minimal_fuel']) {
					$mail->posalert($secondary_characterInfo['email'], $secondary_characterInfo['name'], $row, $row3, $diff);
				}
			}
			
			if($row['result_online']<$config['critical_fuel']) {
				$directorlist = $posmgmt->GetAllUsersWithAccess(6);

				foreach($directorlist as $director) {
					if($row['owner_id']==0) {
						$characterInfo['name']='no one';
					}
					
					if ($director['away']!=1 && isset($director['email']) && $director['id'] != $row['owner_id'] && $director['id'] != $row['secondary_owner_id']) {
					$mail->criticalpossalert($director['email'], $director['name'], $characterInfo['name'], $row, $row3, $diff);
					}
				}

				$directorlist = $posmgmt->GetAllUsersWithAccess(5);
				
				foreach($directorlist as $director) {
					if($row['owner_id']==0) {
						$characterInfo['name']='no one';
					}
					
					if ($director['away']!=1 && isset($director['email']) && $director['id'] != $row['owner_id'] && $director['id'] != $row['secondary_owner_id']) {
					$mail->criticalpossalert($director['email'], $director['name'], $characterInfo['name'], $row, $row3, $diff);
					}
				}	
			}
		}
    }

?>
