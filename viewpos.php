<?php
/**
 * Pos-Tracker2
 *
 * Starbase View page
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
 * @link       http://code.google.com/p/pos-tracker-eve/
 * @link       http://www.eve-online.com/
 */
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eve     = New Eve();
$posmgmt = New POSMGMT();
$eve->SessionSetVar('userlogged', 1);

$userinfo = $posmgmt->GetUserInfo();

$access = $eve->SessionGetVar('access');
$highly_trusted = $eve->SessionGetVar('highly_trusted');
$eve_id = $eve->SessionGetVar('eve_id');

$eveRender->Assign('access', $access);
$eveRender->Assign('config', $config);

if ($access >= 1) {
    $pos_id = $eve->VarCleanFromInput('i');
    if (!empty($pos_id)) {

        $tower = $posmgmt->GetTowerInfo($pos_id);
        //if ($row = mysql_fetch_array($result)) {
		
        if ($tower) {
            $current_isotope         = $tower['isotope'];
            $outpost_id            = $tower['outpost_id'];
            $current_oxygen          = $tower['oxygen'];
            $current_mechanical_parts= $tower['mechanical_parts'];
            $current_coolant         = $tower['coolant'];
            $current_robotics        = $tower['robotics'];
            $current_uranium         = $tower['uranium'];
            $current_ozone           = $tower['ozone'];
            $current_heavy_water     = $tower['heavy_water'];
            $current_strontium       = $tower['strontium'];
            $current_charters        = $tower['charters'];
            $pos_size                = $tower['pos_size'];
            $pos_race                = $tower['pos_race'];
            $towerName               = $tower['towerName'];
            $systemID                = $tower['systemID'];
            $location                = $tower['moonName'];
            $tower_cpu               = $tower['cpu'];
            $tower_pg                = $tower['powergrid'];
            $systemName              = $posmgmt->getSystemName($systemID); //New Call to Function to get System Name from database
            //New Sovereingty Function to retrieve Sovereingty Status
            $tower['sovereignty']    = $posmgmt->getSovereignty($systemID);
            //$sovereignty              = $tower['sovereignty'] = $sov['sovereignty'];
            $allianceid              = $tower['allianceid'];
            $tower['sovfriendly']    = $posmgmt->getSovereigntyStatus($systemID, $allianceid);
            //if ($_SESSION['allainceid'] == $sov['allianceID']) {
            //    $sovfriendly            = $tower['sovfriendly'] = true;
            $charters_needed         = $tower['charters_needed'];
            //$system = $row['system'];
            $pos_id                  = $tower['pos_id'];
            // grabs the new allianceid off the table

			$owner_id				 = $tower['owner_id'];
			$sec_owner_id			 = $tower['secondary_owner_id'];
			
            $owner_info=$posmgmt->GetUserInfofromID($tower['owner_id']);
            $tower['owner_name']=$owner_info['name'];

            $sec_owner_info=$posmgmt->GetUserInfofromID($tower['secondary_owner_id']);
            $tower['secondary_owner_name']=$sec_owner_info['name'];
			$secret_pos         = $tower['secret_pos'];
        }

				
		if ($secret_pos == 1) { //Secret POS Access Check. Will go through if highly trusted or are a fuel tech of the tower.
			if ($highly_trusted == 1 || $eve_id == $owner_id || $eve_id == $secondary_owner_id) {
				if ($access <= 2 && $eve_id != $owner_id && $eve_id != $secondary_owner_id) { //Must be at View-All Manager or higher access to see secret POS.
					$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
					$eve->RedirectUrl('index.php');
					die();
				}
			}
			else {
				$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
				$eve->RedirectUrl('index.php');
				die();
			}
		}
		
		if ($access == 1) { //View Only Access Check, should make sure they are ONLY looking at their own towers.
			if ($eve_id == $owner_id || $eve_id == $secondary_owner_id) {
			}
			else {
					$eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
					$eve->RedirectUrl('index.php');
					die();
			}
		}
		
		
		
        $display_hangar = false;

        $hangars = $posmgmt->GetPosHangars($pos_id);

        $i = 0;
        if($hangars) {
            foreach ($hangars as $row) { //while ($row = mysql_fetch_assoc($res)) {
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
        }

        //Feul table selection
        $db = $posmgmt->selectstaticdb($systemID, $allianceid);
        //End Fuel table selection

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
            $tower['pos_capacity']=$tower['fuel_hangar']=$row['fuel_hangar'];
            $tower['strontium_capacity']=$row['strontium_hangar'];

        }

        //$mods = $posmgmt->GetPosStructures($pos_id);
        $mods = $posmgmt->GetAllPosMods($pos_id);
//echo '<pre>';print_r($tower);echo '</pre>';exit;
        if ($mods) { //if (mysql_num_rows($result) != 0) {
            $current_pg  = 0;
            $current_cpu = 0;
            foreach($mods as $row) { //while ($row = mysql_fetch_array($result)) {
                if ($row['online']) {
                    $current_pg  = $current_pg  + $row['pg'];
                    $current_cpu = $current_cpu + $row['cpu'];
                }
            }
        } else {
            $current_pg = 0;
            $current_cpu = 0;
        }
        if($current_cpu<=0 && $tower['cpu']>0) {
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

        // $avail_uranium          = ($current_uranium          - ($required_uranium * $hoursago)); - Old Version. Now using the API to handle what's in the DB.
		
		$avail_uranium          = $current_uranium;
        $avail_oxygen           = $current_oxygen;
        $avail_mechanical_parts = $current_mechanical_parts;
        $avail_coolant          = $current_coolant;
        $avail_robotics         = $current_robotics;
        $avail_isotope          = $current_isotope;
        $avail_ozone            = $current_ozone;
        $required_ozone2        = ceil(($current_pg / $total_pg) * $required_ozone);
        $avail_heavy_water      = $current_heavy_water;
        $required_heavy_water2  = ceil(($current_cpu / $total_cpu) * $required_heavy_water);
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



        //Begin Silo Tracking Code
        //$sql0 = "SELECT * FROM ".TBL_PREFIX."silo_info WHERE pos_id=".my_escape($pos_id);
        //$res0 = mysql_query($sql0);

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

        $tower['silos'] = $silo;
        $tower['mods']  = $mods;
        $last_update = gmdate("Y-m-d H:i:s", $row2['datetime']);


        $eveRender->Assign('tower',       $tower);
        $eveRender->Assign('last_update', $last_update);
        $eveRender->Assign('hoursago',    $hoursago);

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

        $tower['lines']     = $lines;
        $tower['linecount'] = $linecount;

        $eveRender->Assign('linecount',   $linecount);
        $eveRender->Assign('lines',       $lines);
        $eveRender->Assign('arrposize',   $arrposize);
        $eveRender->Assign('arrporace',   $arrporace);
        $eveRender->Assign('towerstatus', array(0 => 'Unanchored', 1 => 'Anchored', 2 => 'Onlining', 3 => 'Reinforced', 4 => 'Online'));
        $eveRender->Assign('display_hangar',   $display_hangar);
        $eveRender->Assign('hangars',   $hangar);
        $eveRender->Assign('optimal',   $optimal);
        $eveRender->Assign('optimalDiff',   $optimalDiff);
        $eveRender->Display('viewpos.tpl');

    } else {
        $eve->SessionSetVar('errormsg', 'You forgot something');
        $eve->RedirectUrl('track.php');
    }
} else {
    $eve->SessionSetVar('errormsg', 'You do not have access, ask your CEO for access.');
    $eve->RedirectUrl('index.php');
}

?>