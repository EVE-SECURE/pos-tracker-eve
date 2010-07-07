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
 * @version    SVN: $Id: cron_mail.php 243 2009-04-26 16:10:33Z stephenmg $
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
//echo '<pre>';print_r($config); echo '</pre>';exit;
$eve     = New Eve();
$posmgmt = New POSMGMT();

$mail = new posMailer();
$mail->mailinit();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$access = 4;
$eve->SessionSetVar('access', $access);

$eveRender->Assign('access', $access);


    $rows = $posmgmt->GetAllPos2();

    foreach($rows as $key => $row) {

        $row2 = $posmgmt->GetLastPosUpdate($row['pos_id']);
		
		$pos_size                 = $row['pos_size'];
	    $pos_race                 = $row['pos_race'];
	    $systemID                 = $row['systemID'];
		$sov                      = $posmgmt->getSovereignty($systemID);
		$sovereignty              = $sov['sovereigntyLevel'];
		
		//Begin New Sovereignty Code
		$db = $posmgmt->selectstaticdb($sovereignty, $systemID);
		//End New Sovereignty Code

		$row3 = $posmgmt->GetStaticTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size, 'db' => $db));


		$row['result_uptimecalc']= $posmgmt->uptimecalc($row['pos_id']);
		$row['result_online']    = $posmgmt->online($row['result_uptimecalc']);
		$row['last_update']      = gmdate("Y-m-d H:i:s", $row2['datetime']);
		$row['online']           = $posmgmt->daycalc($row['result_online']);
		$row['region']           = $posmgmt->getRegionNameFromMoonID($row['MoonName']);
		$row['system']           = $posmgmt->getSystemName($row['systemID']);
		$row['result_optimal']   = $posmgmt->posoptimaluptime($row3);
				
        $rows[$key] = $row;
		$characterInfo=$posmgmt->GetUserInfofromID($row['owner_id']);
		$secondary_characterInfo=$posmgmt->GetUserInfofromID($row['secondary_owner_id']);
		//echo '<pre>';print_r($characterInfo); echo '</pre>';exit;
		$diff=array('uranium' => $row['result_optimal']['optimum_uranium']-$row['uranium'],
		'oxygen'=> $row['result_optimal']['optimum_oxygen']-$row['oxygen'],
		'mechanical_parts'=> $row['result_optimal']['optimum_mechanical_parts']-$row['mechanical_parts'],
		'coolant'=> $row['result_optimal']['optimum_coolant']-$row['coolant'],
		'robotics'=> $row['result_optimal']['optimum_robotics']-$row['robotics'],
		'isotope'=>$row['result_optimal']['optimum_isotope']-$row['isotope'],
		'ozone'=>$row['result_optimal']['optimum_ozone']-$row['ozone'],
		'heavy_water'=>$row['result_optimal']['optimum_heavy_water']-$row['heavy_water']);
		if($characterInfo['away']!=1 && isset($characterInfo['email']))
		{
			if($row['result_online']<$config['minimal_fuel'])
			{
				$mail->posalert($characterInfo['email'], $characterInfo['name'], $row, $row3, $diff);

			}
		}
		if($secondary_characterInfo['away']!=1 && isset($secondary_characterInfo['email']))
		{
			if($row['result_online']<$config['minimal_fuel'])
			{
				$mail->posalert($secondary_characterInfo['email'], $secondary_characterInfo['name'], $row, $row3, $diff);

			}
		}
		if($row['result_online']<$config['critical_fuel'])
		{
			$directorlist = $posmgmt->GetAllUsersWithAccess(4);

			foreach($directorlist as $director) {
				if($row['owner_id']==0)
				{
					$characterInfo['name']='None';
				}
				$mail->criticalpossalert($director['email'], $director['name'], $characterInfo['name'], $row, $row3, $diff);
			}
		}
    }

?>
