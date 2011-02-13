<?php
/**
 * Pos-Tracker2
 *
 * Starbase Edit page
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

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array('1', $access) && !in_array('5', $access)) {
    $eve->RedirectUrl('login.php');
}

$pos_id = $eve->VarCleanFromInput('i');
// Dirty fix
if (empty($pos_id)) {
    $pos_id = $eve->VarCleanFromInput('pos_id');
}
if (empty($pos_id)) {
    $eve->SessionSetVar('errormsg', 'No POS ID!');
    $eve->RedirectUrl('track.php');
}


$action = $eve->VarCleanFromInput('action');

switch($action) {
    case 'Change Tower Information':

        $newstatus      = $eve->VarCleanFromInput('newstatus');
        $new_tower_name = $eve->VarCleanFromInput('new_tower_name');
        $new_outpost_id	= $eve->VarCleanFromInput('outpostlist');
        $new_pg         = $eve->VarCleanFromInput('new_pg');
        $new_cpu        = $eve->VarCleanFromInput('new_cpu');
        if(!is_numeric($new_pg) || $new_pg<0) {
            $new_pg=0;
        }
        if(!is_numeric($new_cpu) || $new_cpu<0) {
            $new_cpu=0;
        }

        if ($posmgmt->ChangeTowerInfo(array('pos_id' => $pos_id, 'newstatus' => $newstatus, 'new_tower_name' => $new_tower_name, 'new_outpost'=>$new_outpost_id, 'new_pg' => $new_pg, 'new_cpu' => $new_cpu))) {
            $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
            $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        }

        //echo 'Change Tower Information - ' . $newstatus . ' - ' .$new_tower_name;exit;  
        break;
	case 'Change POS Secretive Status':
	
		$new_secret    = $eve->VarCleanFromInput('new_secret');
		if ($new_secret == 0) {
			$new_secret  = 1;
		}
		else {
			$new_secret = 0;
		}
		
        if ($posmgmt->ChangeTowerSecret(array('pos_id' => $pos_id, 'new_secret' => $new_secret))) {
            $eve->SessionSetVar('statusmsg', 'POS Secretive Status Changed!');
            $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        }
        break;
    case 'Update Fuel':

        $fuel['uranium']          = $eve->VarCleanFromInput('uranium');
        $fuel['oxygen']           = $eve->VarCleanFromInput('oxygen');
        $fuel['mechanical_parts'] = $eve->VarCleanFromInput('mechanical_parts');
        $fuel['coolant']          = $eve->VarCleanFromInput('coolant');
        $fuel['robotics']         = $eve->VarCleanFromInput('robotics');
        $fuel['isotope']          = $eve->VarCleanFromInput('isotope');
        $fuel['ozone']            = $eve->VarCleanFromInput('ozone');
        $fuel['heavy_water']      = $eve->VarCleanFromInput('heavy_water');
        $fuel['strontium']        = $eve->VarCleanFromInput('strontium');
        $fuel['charters']         = $eve->VarCleanFromInput('charters');
        if(!is_numeric($fuel['charters']))
        {
              $fuel['charters']=0;
        }
        $fuel['pos_id']           = $pos_id;
        //echo 'Update Fuel';exit;
        if ($posmgmt->UpdatePosFuel($fuel)) {
            $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
            $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        }
        break;
    case 'updatemods':
        $modstates = $eve->VarCleanFromInput('mod');
        //echo '<pre>';print_r($modstates);echo '</pre>';
        //echo 'Update Fuel';exit;

        if ($posmgmt->UpdateAllPosModsState(array('pos_id' => $pos_id, 'mods' => $modstates))) {
            $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
            $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        }
        break;

    case 'updateminers':
        $modmat = $eve->VarCleanFromInput('material');
        //echo '<pre>';print_r($modmat);echo '</pre>';exit;

        foreach($modmat as $structure_id => $material_id) {
            if (!$posmgmt->ChangeMinerMat(array('structure_id' => $structure_id, 'material_id' => $material_id))) {
                $eve->SessionSetVar('errormsg', 'Problem Saving Material');
                $eve->RedirectUrl('editpos.php?i='.$pos_id);
            }
        }
        $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
        $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        break;
    case 'updatesilos':
        $material   = $eve->VarCleanFromInput('material');
        $direction  = $eve->VarCleanFromInput('direction');
        $new_amount = $eve->VarCleanFromInput('new_amount');
        $connection = $eve->VarCleanFromInput('connection');
        $links      = $eve->VarCleanFromInput('links');

        $silos = array();

        foreach($material as $siloid => $mat_id) {
            $silos[$siloid]['material_id'] = $mat_id;
        }
        foreach($direction as $siloid => $way) {
            $silos[$siloid]['status'] = (($way=='Input') ? 0 : 1);
        }
        foreach($new_amount as $siloid => $amount) {
            $silos[$siloid]['material_ammount'] = $amount;
        }
        foreach($connection as $siloid => $connection_id) {
            $silos[$siloid]['connection_id'] = $connection_id;
        }
        foreach($links as $siloid => $silo_link) {
            $silos[$siloid]['silo_link'] = (($silo_link) ? $silo_link : 0);
        }
        $silokeys = array_keys($silos);
        foreach ($silokeys as $key) {
            $silos[$key]['structure_id'] = $key;
        }
        $args = array('pos_id' => $pos_id, 'silos' => $silos);
        //echo '<pre>';print_r($args);echo '</pre>';exit;
        if ($posmgmt->UpdateAllPosSilos($args)) {
            $eve->SessionSetVar('statusmsg', 'All Silos updated');
            $eve->RedirectUrl('viewpos.php?i='.$pos_id);
        }
        break;
    case 'Assign As Fuel Tech':
        $newowner=$eve->VarCleanFromInput('newowner');
        $args=array('pos_id'=>$pos_id, 'newowner_id'=>$newowner);
        $posmgmt->updateOwner($args, $backup=false);
        break;
    case 'Assign As Backup Fuel Tech':
        $newowner=$eve->VarCleanFromInput('newowner');
        $args=array('pos_id'=>$pos_id, 'newowner_id'=>$newowner);
        $posmgmt->updateOwner($args, $backup=true);
        break;
}



$tower = $posmgmt->GetTowerInfo($pos_id);

if ($tower) {
    $current_isotope          = $tower['isotope'];
	$outpost_id               = $tower['outpost_id'];
    $outpost_name             = $tower['outpost_name'];
    $current_oxygen           = $tower['oxygen'];
    $current_mechanical_parts = $tower['mechanical_parts'];
    $current_coolant          = $tower['coolant'];
    $current_robotics         = $tower['robotics'];
    $current_uranium          = $tower['uranium'];
    $current_ozone            = $tower['ozone'];
    $current_heavy_water      = $tower['heavy_water'];
    $current_strontium        = $tower['strontium'];
    $current_charters         = $tower['charters'];
    $pos_size                 = $tower['pos_size'];
    $pos_race                 = $tower['pos_race'];
    $towerName                = $tower['towerName'];
    $systemID                 = $tower['systemID'];
    $location                 = $tower['moonName'];
    $tower_cpu                = $tower['cpu'];
    $tower_pg                 = $tower['powergrid'];
    $systemName               = $posmgmt->getSystemName($systemID); //New Call to Function to get System Name from database
    $allianceid               = $tower['allianceid'];
    //New Sovereingty Function to retrieve Sovereingty Status
    $tower['sovereignty']     = $posmgmt->getSovereignty($systemID);
    //$sovereignty              = $tower['sovereignty'] = $sov['sovereignty'];
    $allianceid               = $tower['allianceid'];
    $tower['sovfriendly']     = $posmgmt->getSovereigntyStatus($systemID, $allianceid);
    $charters_needed          = $tower['charters_needed'];
    //$system = $row['system'];
    $pos_id                   = $tower['pos_id'];
    // grabs the new allianceid off the table

	$owner_id				 = $tower['owner_id'];
	$sec_owner_id			 = $tower['secondary_owner_id'];
	
    $owner_info=$posmgmt->GetUserInfofromID($tower['owner_id']);
    $tower['owner_name']=$owner_info['name'];

    $sec_owner_info=$posmgmt->GetUserInfofromID($tower['secondary_owner_id']);
    $tower['secondary_owner_name']=$sec_owner_info['name'];
	$secret_pos         = $tower['secret_pos'];
}

       if (!in_array('1', $access) && !in_array('5', $access)) { //quick user check
		
			$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
			$eve->RedirectUrl('index.php');
			die();
			
		}
		elseif (in_array('5', $access) || $tower['owner_id'] == $userinfo['eve_id'] || $tower['secondary_owner_id'] == $userinfo['eve_id']){
		
		//Admin or tower owner logged in so kill the checkers so show the tower
		
		}
		elseif ($tower['secret_pos'] == 0) { //Not secret towers
		
			if ($tower['corp'] == $userinfo['corp']) { 
				
					if (!in_array('21', $access) && !in_array('22', $access)) {
			
					$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
					$eve->RedirectUrl('index.php');
					die();
			
					}
				
			}

			else {
			
				if (!in_array('51', $access) && !in_array('52', $access)) {
			
					$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
					$eve->RedirectUrl('index.php');
					die();
			
				}
			
			}
		
		}
		elseif ($tower['secret_pos'] == 1) { //Secret towers
		
			if ($tower['corp'] == $userinfo['corp']) {
				
					if (!in_array('22', $access)) {
			
						$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
						$eve->RedirectUrl('index.php');
						die();
			
					}
				
			}

			else {
			
				if (!in_array('52', $access)) {
			
					$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
					$eve->RedirectUrl('index.php');
					die();
			
				}
			
			}
		
		}

		
//Begin Outpost association edit
$outpost=$posmgmt->GetAllOutpost();
$ouptost_list=array();
$outpost_list[0]='None';
foreach($outpost as $outpostlist)
{
	$outpost_list[$outpostlist['outpost_id']]=$outpostlist['outpost_name'];
}
//End outpost Association edit

$display_hangar = false;

$hangars = $posmgmt->GetPosHangars($pos_id);

$i = 0;
foreach ($hangars as $row) {
    $display_hangar = true;
    $hangar[$i]['online']           = $row['online'];
    $hangar[$i]['isotope']          = $row['isotope'];
    $hangar[$i]['oxygen']           = $row['oxygen'];
    $hangar[$i]['mechanical_parts'] = $row['mechanical_parts'];
    $hangar[$i]['coolant']          = $row['coolant'];
    $hangar[$i]['robotics']         = $row['robotics'];
    $hangar[$i]['uranium']          = $row['uranium'];
    $hangar[$i]['ozone']            = $row['ozone'];
    $hangar[$i]['heavy_water']      = $row['heavy_water'];
    $hangar[$i]['strontium']        = $row['strontium'];
    $hangar[$i]['charters']         = $row['charters'];
    $i++;
}

//Begin New Sovereignty Code
$db = $posmgmt->selectstaticdb($systemID, $allianceid);
//End New Sovereignty Code

$row = $posmgmt->GetStaticTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size, 'db' => $db));

if ($row) {
    $tower['required_isotope']           = $row['isotopes'];
    $tower['required_oxygen']            = $row['oxygen'];
    $tower['required_mechanical_parts']  = $row['mechanical_parts'];
    $tower['required_coolant']           = $row['coolant'];
    $tower['required_robotics']          = $row['robotics'];
    $tower['required_uranium']           = $row['uranium'];
    $tower['required_ozone']             = $row['ozone'];
    $tower['required_heavy_water']       = $row['heavy_water'];
    $tower['required_strontium']         = $row['strontium'];
    $tower['required_charters']          = $charters_needed?1:0;
    $tower['race_isotope']               = $result['race_isotope'];
    $tower['total_pg']                   = $row['pg'];
    $tower['total_cpu']                  = $row['cpu'];
    $required_isotope                    = $row['isotopes'];
    $required_oxygen                     = $row['oxygen'];
    $required_mechanical_parts           = $row['mechanical_parts'];
    $required_coolant                    = $row['coolant'];
    $required_robotics                   = $row['robotics'];
    $required_uranium                    = $row['uranium'];
    $required_ozone                      = $row['ozone'];
    $required_heavy_water                = $row['heavy_water'];
    $required_strontium                  = $row['strontium'];
    $required_charters                   = $charters_needed?1:0;
    $race_isotope                        = $result['race_isotope'];
    $total_pg                            = $row['pg'];
    $total_cpu                           = $row['cpu'];
    $tower['uptimecalc']                 = $posmgmt->uptimecalc($pos_id);
    $strontium_capacity                  = $row['strontium_hangar'];
    $pos_capacity                        = $row['fuel_hangar'];
    $tower['strontium_capacity']         = $strontium_capacity;
	$tower['pos_capacity']=$tower['fuel_hangar']=$row['fuel_hangar'];
}

$mods = $posmgmt->GetAllPosMods($pos_id);
if ($mods) {
    $current_pg  = 0;
    $current_cpu = 0;
    foreach($mods as $row) {
        if ($row['online']) {
            $current_pg  = $current_pg  + $row['pg'];
            $current_cpu = $current_cpu + $row['cpu'];
        }
    }
} else {
    $current_pg = 0;
    $current_cpu = 0;
}
if($current_cpu<=0 && $tower_cpu>0) {
            $current_cpu=$tower_cpu;
        }
if($current_pg<=0 && $tower_pg>0) {
       $current_pg=$tower_pg;
}

$tower['current_pg']  = $current_pg;
$tower['current_cpu'] = $current_cpu;
$row2 = $posmgmt->GetLastPosUpdate($pos_id);
$last_update = gmdate("Y-m-d H:i:s", $row2['datetime']);

$hoursago = $posmgmt->hoursago($pos_id, 1);

$optimal=$posmgmt->posoptimaluptime($tower);
$optimalDiff=$posmgmt->getOptimalDifference($optimal, $tower);
		
		$avail_uranium          = $current_uranium;
        $avail_oxygen           = $current_oxygen;
        $avail_mechanical_parts = $current_mechanical_parts;
        $avail_coolant          = $current_coolant;
        $avail_robotics         = $current_robotics;
        $avail_isotope          = $current_isotope;
        $avail_ozone            = $current_ozone;
        $required_ozone2        = round(($current_pg / $total_pg) * $required_ozone);
        $avail_heavy_water      = $current_heavy_water;
        $required_heavy_water2  = round(($current_cpu / $total_cpu) * $required_heavy_water);
        $avail_strontium        = $current_strontium;
        $avail_charters         = $current_charters;
		
if ($avail_uranium <= 0) {
    $avail_uranium = ($current_uranium - ($required_uranium * (floor($current_uranium / $required_uranium))));
}
if ($avail_oxygen <= 0) {
    $avail_oxygen = ($current_oxygen - ($required_oxygen * (floor($current_oxygen / $required_oxygen))));
}
if ($avail_mechanical_parts <= 0) {
    $avail_mechanical_parts = ($current_mechanical_parts - ($required_mechanical_parts * (floor($current_mechanical_parts / $required_mechanical_parts))));
}
if ($avail_coolant <= 0) {
    $avail_coolant = ($current_coolant - ($required_coolant * (floor($current_coolant / $required_coolant))));
}
if ($avail_robotics <= 0) {
    $avail_robotics = ($current_robotics - ($required_robotics * (floor($current_robotics / $required_robotics))));
}
if ($avail_isotope <= 0) {
    $avail_isotope = ($current_isotope - ($required_isotope * (floor($current_isotope / $required_isotope))));
}
if ($avail_ozone <= 0 && $current_pg) {
    $avail_ozone = ($current_ozone - ((ceil(($current_pg / $total_pg) * $required_ozone)) * (floor($current_ozone / (ceil(($current_pg / $total_pg) * $required_ozone))))));
}
if ($avail_heavy_water <= 0 && $current_cpu) {
    $avail_heavy_water = ($current_heavy_water - ((ceil(($current_cpu / $total_cpu) * $required_heavy_water)) * (floor($current_heavy_water / (ceil(($current_cpu / $total_cpu) * $required_heavy_water))))));
}
if ($avail_charters <= 0 && $required_charters) {
    $avail_charters = ($current_charters - ($required_charters * (floor($current_charters / $required_charters))));
}

$tower['avail_uranium']           = $avail_uranium;
$tower['avail_oxygen']            = $avail_oxygen;
$tower['avail_mechanical_parts']  = $avail_mechanical_parts;
$tower['avail_coolant']           = $avail_coolant;
$tower['avail_robotics']          = $avail_robotics;
$tower['avail_isotope']           = $avail_isotope;
$tower['avail_ozone']             = $avail_ozone;
$tower['required_ozone2']         = $required_ozone2;
$tower['avail_heavy_water']       = $avail_heavy_water;
$tower['required_heavy_water2']   = $required_heavy_water2;
$tower['avail_strontium']         = $avail_strontium;
$tower['avail_charters']          = $avail_charters;

$res0 = $posmgmt->GetPosSilos($pos_id);

$silocap = array(1  => 30000,
                 2  => 20000,
                 3  => 40000,
                 4  => 20000,
                 5  => 20000,
                 6  => 30000,
                 7  => 30000,
                 8  => 20000,
                 9  => 20000,
                 10 => 20000,
                 11 => 30000,
                 12 => 40000,
                 13 => 40000,
                 14 => 30000);

$x = 0;
$display_silo = false;

foreach ($res0 as $row0) {
    //$silo = array();
    $display_silo = true;

    $available_material = $current_material_vol = $available_silo_vol = $hourstofill = $silo_material_ammount = 0;

    //Basic info about Silo
    $x                      = $row0['silo_id'];
    $silo_link              = $row0['silo_link'];
    $silo_id                = $row0['silo_id'];
    $silo_type              = $row0['silo_type'];
    $silo_material_id       = $row0['material_id'];
    $silo_material_ammount  = $row0['material_ammount'];
    $silo_status            = $row0['status'];
    $silo_connection        = $row0['connection_id'];
    //How long ago was the silo updated
    $hoursago                     = floor($posmgmt->hoursago($silo_id, 2));
    $silo[$x]['hoursago']         = $hoursago;
    $silo[$x]['silo_id']          = $row0['silo_id'];
    $silo[$x]['silo_type']        = $row0['silo_type'];
    $silo[$x]['material_id']      = $row0['material_id'];
    //$silo[$x]['material_ammount'] =  $row0['material_id'];
    $silo[$x]['material_amount']  = $row0['material_ammount'];
    $silo[$x]['status']           = $row0['status'];
    $silo[$x]['connection_id']    = $row0['connection_id'];
    $silo[$x]['silo_link']        = (($row0['silo_link']) ? $row0['silo_link'] : 0);
    //if ($x == 495) { echo '<pre>';print_r($silo[$x]);echo '</pre>';exit; }
    //reactor/harvester info
    $row = $posmgmt->GetConnectedReator($silo_connection);

    if ($row) {
        $structure_type         = $row['structure_type'];
        $structure_material_id  = $row['material_id'];
        $silo[$x]['structure_type']         = $row['structure_type'];
        $silo[$x]['structure_material_id']  = $row['material_id'];
    }

    //Reactor/Harvster Name/type
    $struct = $posmgmt->GetStaticModInfo($structure_type);

    if ($struct) {
        $silo[$x]['structure_name'] = $struct['name'];
    }

    $matinfo = $posmgmt->GetStaticMatInfo($structure_material_id);

    if ($matinfo) {
        $silo[$x]['structure_material_name'] = $matinfo['material_name'];
    }

    //Moon harvester Rate
    if ($structure_type==16221 && $structure_material_id == $silo_material_id) {
        $rate = 100;
    }

    //Reactor Rates
    if($structure_type==16869 || $structure_type==20175) {
        //Reaction info
        $reactioninfo = $posmgmt->GetStaticReactionInfo($structure_material_id);

        if ($reactioninfo) {
            //For Output Silo
            if ($silo_material_id == $reactioninfo['material_id']) {
                $rate = $reactioninfo['material_produced'];
            } else {
                //For Input Silo
                if ($reactioninfo['material1_id'] == $silo_material_id) {
                    $rate = $reactioninfo['material1_required'];
                }
                if ($reactioninfo['material2_id'] == $silo_material_id) {
                    $rate = $reactioninfo['material2_required'];
                }
                if ($reactioninfo['material3_id'] == $silo_material_id) {
                    $rate = $reactioninfo['material3_required'];
                }
                if ($reactioninfo['material4_id'] == $silo_material_id) {
                    $rate = $reactioninfo['material4_required'];
                }
            }
        }
    }
    if (!$rate) { $rate = 100; }
    //Silo Material Information
    $smatinfo = $posmgmt->GetStaticMatInfo($silo_material_id);

    if ($smatinfo) {
        $silo[$x]['material_name'] = $smatinfo['material_name'];
        $silo[$x]['material_volume'] = $smatinfo['material_volume'];
        $material_volume = $smatinfo['material_volume'];
    }
    $silo[$x]['rate']                = $rate;
    $silo[$x]['rate_vol']            = $rate * $smatinfo['material_volume'];

    $silo[$x]['silo_capacity'] = $silocap[$tower['pos_race']];

    if($silo_status == 1) {

        //$rate_vol = $rate * $material_volume;
        $silo[$x]['direction']  = 'Output';


        $matinfo = $posmgmt->GetStaticMatInfo($silo[$x]['material_id']);
        $row = $posmgmt->GetConnectedReator($silo[$x]['connection_id']);
        if ($row) {
            $silo[$x]['structure_type']         = $row['structure_type'];
            $silo[$x]['structure_material_id']  = $row['material_id'];
        }
        if ($silo[$x]['structure_type'] == 16221 && $silo[$x]['structure_material_id'] == $silo[$x]['material_id']) {
            // Harvestor
            $rate = 100;
        }

        $rate_vol = $rate * $matinfo['material_volume'];

        $silo[$x]['rate']                = $rate;
        $silo[$x]['rate_vol']            = $rate_vol;
        $silo[$x]['material_volume']     = $matinfo['material_volume'];
        $silo[$x]['material_amount_max'] = $silo[$x]['silo_capacity'] / $silo[$x]['material_volume'];

        //$silo[$x]['hoursago'] = floor($posmgmt->hoursago($silo[$x], 2));

        if (!$silo[$x]['silo_link']) {

            $silo[$x]['material_amount']      = ($rate_vol*$silo[$x]['hoursago'])+$silo[$x]['material_amount'];///$matinfo['material_volume']+$silo[$x]['material_amount'];
            $silo[$x]['current_material_vol'] = $silo[$x]['material_amount'] * $silo[$x]['material_volume'];
            $silo[$x]['available_silo_vol']   = $silo[$x]['silo_capacity'] - $silo[$x]['current_material_vol'];
            if ($silo[$x]['available_silo_vol'] < 0) { $silo[$x]['available_silo_vol'] = 0; }

            $silo[$x]['hourstofill'] = @floor($silo[$x]['available_silo_vol'] / $rate / $matinfo['material_volume']);

            $silo[$x]['hourstofill_total']     = @floor($silo[$x]['silo_capacity'] / $rate / $matinfo['material_volume']);///$matinfo['material_volume']+$silo[$x]['material_amount'];
            $silo[$x]['hourstofill_txt']       = $posmgmt->daycalc($silo[$x]['hourstofill']);
            $silo[$x]['hourstofill_total_txt'] = $posmgmt->daycalc($silo[$x]['hourstofill_total']);

            $silo[$x]['full'] = (($silo[$x]['current_material_vol'] >= $silo[$x]['silo_capacity']) ? 1 : 0);

            if ($silo[$x]['full']) {
                $silo[$x]['available_silo_vol'] = 0;
                $silo[$x]['material_amount']    = $silo[$x]['silo_capacity'] / $matinfo['material_volume'];
                $silo[$x]['current_material_vol'] = $silo[$x]['material_amount'] * $silo[$x]['material_volume'];
            }
        } else {
            $linked = $silo[$silo[$x]['silo_link']];
            if (!$linked['full']) {
                $silo[$x]['material_amount']    = 0;
                $silo[$x]['available_silo_vol'] = $silo[$x]['silo_capacity'];
                $silo[$x]['hourstofill']        = @floor(($silo[$x]['available_silo_vol']+$linked['available_silo_vol']) / $rate / $matinfo['material_volume']);
                $silo[$x]['hourstofill_total']  = @floor(($silo[$x]['silo_capacity'] / $rate / $matinfo['material_volume']) + $linked['hourstofill']);
            } else {
                $silo[$x]['material_amount']    = ($rate_vol*$silo[$x]['hoursago'])/$matinfo['material_volume']+$silo[$x]['material_amount'];
                $silo[$x]['current_material_vol'] = $silo[$x]['material_amount'] * $silo[$x]['material_volume'];
                $silo[$x]['available_silo_vol'] = $silo[$x]['silo_capacity'] - $silo[$x]['current_material_vol'];
                $silo[$x]['hourstofill']        = @floor($silo[$x]['available_silo_vol'] / $rate / $silo[$x]['material_volume']);

                $silo[$x]['hourstofill_total']  = @floor($silo[$x]['silo_capacity'] / $rate_vol * $matinfo['material_volume']);
            }
            $silo[$x]['full']                  = (($silo[$x]['current_material_vol'] >= $silo[$x]['silo_capacity']) ? 1 : 0);
            $silo[$x]['hourstofill_txt']       = $posmgmt->daycalc($silo[$x]['hourstofill']);
            $silo[$x]['hourstofill_total_txt'] = $posmgmt->daycalc($silo[$x]['hourstofill_total']);

        }

        //if ($tower['pos_id'] == 51 && $x == 476)
        //if ($tower['pos_id'] == 18){// && $x == 476)
        //    echo $tower['pos_race'].'<pre>';print_r($silo);echo '</pre>';exit;
        //}


    } else {
        //Silo is emptying, input silo
        $silo[$x]['material_amount_orig'] = $silo[$x]['material_amount'];
        $silo[$x]['material_amount']     = $silo[$x]['material_amount']-($hoursago*$rate);
        $silo[$x]['material_amount_max'] = $silo[$x]['silo_capacity'] / $silo[$x]['material_volume'];//-($hoursago*$rate);
        $silo[$x]['hourstogo']       = $silo[$x]['hourstofill'] = @floor($silo[$x]['material_amount']/$rate);
        $silo[$x]['direction']       = 'Input';
        $silo[$x]['empty']           = (($silo[$x]['material_amount'] <= 0) ? 1 : 0);//(($silo[$x]['hourstogo'] <= 0) ? 1 : 0);
        if ($silo[$x]['hourstogo'] < 0) {
            $silo[$x]['hourstogo'] = $silo[$x]['hourstofill'] = 0;

        }
        $silo[$x]['hourstogo_txt']       = $posmgmt->daycalc($silo[$x]['hourstogo']);
        $hours = $silo[$x]['hourstogo'];
    }//if ($x == 89) { echo '<pre>';print_r($silo[$x]);echo '</pre>';exit; }
}
//End Silo Tracking Code

$miners = $posmgmt->GetPosMiners($pos_id);

$optminers[0] = 'None';
foreach($miners as $key => $miner) {
    $miners[$key] = array_merge($miner, $posmgmt->GetStaticModInfo($miner['structure_type']));
    if ($miner['material_id'] != 0) {
        $miners[$key] = array_merge($miners[$key], $posmgmt->GetStaticMatInfo($miner['material_id']));
    }
    $optminers[$miner['structure_id']] = $miners[$key]['material_name'] . ' - ' . $miners[$key]['name'];
}
//echo '<pre>';print_r($miners);echo '</pre>';exit;
$materials = $posmgmt->GetStaticMaterials();
$optmaterials[0] = 'None';
foreach($materials as $mat) {
    if ($mat['material_id'] == 0) { continue; }
    $optmaterials[$mat['material_id']] = $mat['material_name'];
}
$optdirections = array('Input' => 'Input', 'Output' => 'Output');
//$seldirection  = (($silo['status']>0) ? 'Output' : 'Input');
//echo '<pre>';print_r($miners);echo '</pre>';exit;
if (in_array('5', $access) || in_array('42', $access) || in_array('43', $access) || in_array('44', $access))
{
$tower['silos']  = $silo;
$tower['mods']   = $mods;
$tower['miners'] = $miners;
}
$last_update = gmdate("Y-m-d H:i:s", $row2['datetime']);
//echo '<pre>';print_r($tower);echo '</pre>';exit;

$eveRender->Assign('tower',         $tower);
$eveRender->Assign('last_update',   $last_update);
$eveRender->Assign('hoursago',      $hoursago);
$eveRender->Assign('optmaterials',  $optmaterials);
$eveRender->Assign('optdirections', $optdirections);
$eveRender->Assign('optminers',     $optminers);
$eveRender->Assign('materials',     $materials);

//echo '<pre>';print_r($silo);echo '</pre>';exit;
$arrposize = array(1  => 'Small', 2 => 'Medium', 3 => 'Large');
$arrporace = array(1  => 'Amarr CT',
                   2  => 'Caldari CT',
                   3  => 'Gallente CT',
                   4  => 'Minmatar CT',
                   5  => 'Angel CT',
                   6  => 'Blood CT',
                   7  => 'Dark Blood CT',
                   8  => 'Domination CT',
                   9  => 'Dread Guristas CT',
                   10 => 'Guristas CT',
                   11 => 'Sansha CT',
                   12 => 'Serpentis CT',
                   13 => 'Shadow CT',
                   14 => 'True Sansha CT');
/*
// Searching for Harvestors as first link...
$linkcount = 0;
foreach ($mods as $mod) {
    if ($mod['type_id'] == 16221 || $mod['type_id'] == 14343 || $mod['type_id'] == 20175 || $mod['type_id'] == 16869) {
        switch($mod['type_id']) {
            case 16221:
                $minetype = 1;
                break;
            case 14343:
                $minetype = 2;
                break;
            case 20175:
                $minetype = 3;
                break;
            case 16869:
                $minetype = 3;
                break;
            default:
                $minetype = 1;
                break;
        }
        $minemod  = array_merge($mod, array('minetype' => $minetype), $posmgmt->GetConnectionLine(array('id' => $mod['mod_id'], 'type' => $minetype, 'pos_id' => $pos_id)));
        $material = $posmgmt->GetStaticMatInfo($minemod['material_id']);
        $minemod  = array_merge($minemod, $material);
        //echo '<pre>';print_r($material);echo '</pre>';exit;
        if ($mod['type_id'] == 16221 || (isset($minemod['link_from']) && $minemod['link_from'] == 0)) {
            $starters[$minemod['mod_id']] = $minemod;
        }
        $miningmods[$minemod['mod_id']] = $minemod;
    }
}

$linecount = count($starters);
//echo '<pre>';print_r($miningmods);echo '</pre>';exit;
$x = 0;

foreach ($starters as $starter) {

    $lines[$x][] = $miningmods[$starter['mod_id']]; //$line;

    if ($starter['link_to']) {
        $line = $miningmods[$starter['link_to']];
        $lines[$x][] = $line;

        if (isset($line['link_to']) && $line['link_to'] != 0) {
            $line = $miningmods[$line['link_to']];
            $lines[$x][] = $line;
        } else {
            $x++;
            continue;
        }

        if (isset($line['link_to']) && $line['link_to'] != 0) {
            $line = $miningmods[$line['link_to']];
            $lines[$x][] = $line;
        } else {
            $x++;
            continue;
        }

        if (isset($line['link_to']) && $line['link_to'] != 0) {
            $line = $miningmods[$line['link_to']];
            $lines[$x][] = $line;
        } else {
            $x++;
            continue;
        }

        if (isset($line['link_to']) && $line['link_to'] != 0) {
            $line = $miningmods[$line['link_to']];
            $lines[$x][] = $line;
        } else {
            $x++;
            continue;
        }
    } else {
        $x++;
        continue;
    }
//echo '<pre>';print_r($lines);echo '</pre>';exit;

}*/
//echo '<pre>';print_r($mods);echo '</pre>';exit;

$users = $posmgmt->GetAllUsersArray();

$tower['lines']     = $lines;
$tower['linecount'] = $linecount;
$tower['hangars']   = $hangar;

$eveRender->Assign('linecount',   $linecount);
$eveRender->Assign('lines',       $lines);
$eveRender->Assign('hangars',     $hangar);
$eveRender->Assign('arrposize',   $arrposize);
$eveRender->Assign('arrporace',   $arrporace);
$eveRender->Assign('arronline',   array(1 => 'Online', 0 => 'Anchored', 100 => 'Remove'));
$eveRender->Assign('towerstatus', array(0 => 'Unanchored', 1 => 'Anchored', 2 => 'Onlining', 3 => 'Reinforced', 4 => 'Online'));
$eveRender->Assign('outpostlist', $outpost_list);
$eveRender->Assign('users',     $users);
$eveRender->Assign('optimal',   $optimal);
$eveRender->Assign('optimalDiff',   $optimalDiff);
$eveRender->Assign('secret_pos',	$secret_pos);
/*0 - Unanchored (also unanchoring??) (has valid stateTimestamp)
Note that moonID is zero for unanchored Towers, but locationID will still yield the solar system ID
1 - Anchored / Offline (no time information stored)
2 - Onlining (will be online at time = onlineTimestamp)
3 - Reinforced (until time = stateTimestamp)
4 - Online (continuously since time = onlineTimestamp)*/

$eveRender->Display('editpos.tpl');

?>
