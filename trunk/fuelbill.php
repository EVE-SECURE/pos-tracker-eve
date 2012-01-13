<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';
include_once 'includes/pos_val.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo', $userinfo);
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$pID = 'fuelbill';
$eveRender->Assign('pID', $pID);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (in_array('1', $access) || in_array('5', $access) || in_array('6', $access)) {

	$fuel_A_fuelblock       = 0;
	$fuel_A_total_size     = 0;
	$fuel_A_total      = 0;
	$fuel_C_fuelblock       = 0;
	$fuel_C_total_size     = 0;
	$fuel_C_total      = 0;
	$fuel_G_fuelblock       = 0;
	$fuel_G_total_size     = 0;
	$fuel_G_total      = 0;
	$fuel_M_fuelblock       = 0;
	$fuel_M_total_size     = 0;
	$fuel_M_total      = 0;
    $default_days           = 0;
	$total_size = 0;
	$charter_total_size = 0;
	$charter_total = 0;
	$fb_total_size = 0;

    $args = array();
    $filter  = $eve->VarCleanFromInput('filter');
    $submit = $eve->VarCleanFromInput('submit');
    $use_current_levels = $eve->VarCleanFromInput('use_current_levels');
	$display_optimal	= $eve->VarCleanFromInput('display_optimal');

    if (!empty($filter) || !empty($submit)) {

        $days_to_refuel = $eve->VarCleanFromInput('days_to_refuel');

        if (is_numeric($days_to_refuel)) {
            $args['days_to_refuel'] = $days_to_refuel;
        } else {
            $default_days = 0;
        }

        $pos_ids = $eve->VarCleanFromInput('pos_ids');
        if (is_array($pos_ids)) {
            $optposids = $pos_ids;
            $pos_ids = array_keys($pos_ids);
            $args['pos_ids'] = $pos_ids;
        }

        $systemID = $eve->VarCleanFromInput('systemID');
        if (!empty($systemID)) {
            $args['systemID'] = $systemID;
        }

        $constellationID = $eve->VarCleanFromInput('constellationID');
        if (!empty($constellationID)) { //echo $constellationID;exit;
            $args['constellationID'] = $constellationID;
        }

        $regionID = $eve->VarCleanFromInput('regionID');
        if (!empty($regionID)) { //echo $regionID;exit;
            $args['regionID'] = $regionID;
        }

    } else {
        $pos_id = $eve->VarCleanFromInput('pos_id');
        if (!empty($pos_id) && is_numeric($pos_id)) {
            $args['pos_ids'][] = $pos_id;
        }

        $systemID = $eve->VarCleanFromInput('systemID');
        if (!empty($systemID)) {
            $args['systemID'] = $systemID;
        }

        $constellationID = $eve->VarCleanFromInput('constellationID');
        if (!empty($constellationID)) {
            $args['constellationID'] = $constellationID;
        }

        $regionID = $eve->VarCleanFromInput('regionID');
        if (!empty($regionID)) { //echo $regionID;exit;
            $args['regionID'] = $regionID;
        }
    }

    if (!isset($days_to_refuel) || empty($days_to_refuel)) {
        $days_to_refuel = $default_days;
    }


    $regions = $posmgmt->GetInstalledRegions();
    $constellations = $posmgmt->GetConstellationsWithPos();
    $systems = $posmgmt->GetSystemsWithPos();

    $optregions[] = 'All Regions';
    foreach ($regions as $regID => $region) {
        $optregions[$regID] = $region['regionName'];
    }

    $optconstellations[] = 'All Constellations';
    foreach ($constellations as $constID => $constellation) {
        $optconstellations[$constellation['constellationID']] = $constellation['constellationName'];
    }

    $optsystems[] = 'All Systems';
    foreach ($systems as $sysID => $system) {
        $optsystems[$system['solarSystemID']] = $system['solarSystemName'];
    }

    $optlevels = array(1 => 'Current Level - Yes', 0 => 'Current Level - No');
	$disopt = array(1 => 'Display Optimals - Yes', 0 => 'Display Optimals - No');

    $eveRender->Assign('regions',            $regions);
    $eveRender->Assign('optregions',         $optregions);
    $eveRender->Assign('constellations',     $constellations);
    $eveRender->Assign('optconstellations',  $optconstellations);
    $eveRender->Assign('systems',            $systems);
    $eveRender->Assign('optsystems',         $optsystems);
    $eveRender->Assign('default_days',       $default_days);
    $eveRender->Assign('days_to_refuel',     $days_to_refuel);
    $eveRender->Assign('regionID',           $regionID);
    $eveRender->Assign('constellationID',    $constellationID);
    $eveRender->Assign('systemID',           $systemID);
    $eveRender->Assign('use_current_levels', $use_current_levels);
	$eveRender->Assign('display_optimal',    $display_optimal);
    $eveRender->Assign('optlevels',          $optlevels);
	$eveRender->Assign('disopt',          	 $disopt);
    $eveRender->Assign('optposids',          $optposids);

    $count = 0;
    $args['use_current_levels'] = $use_current_levels;
	$args['display_optimal'] = $display_optimal;
    $towers = $posmgmt->GetFuelBill($args);
	
    foreach ($towers as $key => $tower) {

        if (!in_array('1', $access) && !in_array('5', $access) && !in_array('6', $access)) { //quick user check
		
			continue ; //Hide the tower
			
		}
		elseif (in_array('5', $access) || in_array('6', $access) || $tower['owner_id'] == $userinfo['eve_id'] || $tower['secondary_owner_id'] == $userinfo['eve_id']){
		
		//Admin or tower owner logged in so kill the checkers so show the tower
		
		}
		elseif ($tower['secret_pos'] == 0) { //Not secret towers
		
			if ($tower['corp'] == $userinfo['corp']) { 
				
					if (!in_array('20', $access) && !in_array('21', $access) && !in_array('22', $access)) {
			
					continue ;
			
					}
				
			}

			else {
			
				if (!in_array('50', $access) && !in_array('51', $access) && !in_array('52', $access)) {
			
				continue ;
			
				}
			
			}
		
		}
		elseif ($tower['secret_pos'] == 1) { //Secret towers
		
			if ($tower['corp'] == $userinfo['corp']) {
				
					if (!in_array('22', $access)) {
			
					continue ;
			
					}
				
			}

			else {
			
				if (!in_array('52', $access)) {
			
				continue ;
			
				}
			
			}
		
		}

        $tower['constellationName'] = $posmgmt->getConstellationNameFromMoonID($tower['locationName']);
        $tower['regionName']      = $posmgmt->getRegionNameFromMoonID($tower['locationName']);
		
		switch($tower['pos_race']) {
				case 1:
				case 6:
				case 7:
				case 11:
				case 14:
					$fuel_A_total = $fuel_A_total + $tower['fuel_A_fuelblock'];break;
				case 4:  
				case 5: 
				case 8:
					$fuel_M_total = $fuel_M_total + $tower['fuel_M_fuelblock'];break;
				case 2:  
				case 9: 
				case 10: 
					$fuel_C_total = $fuel_C_total + $tower['fuel_C_fuelblock'];break;
				case 3:
				case 12:
				case 13:
					$fuel_G_total = $fuel_G_total + $tower['fuel_G_fuelblock'];break;
			}
		
		$charter_total = $charter_total + $tower['fuel_charters'];
		$fb_total_size = $fb_total_size + $tower['fb_total_volume'];
		
		if ($tower['fuel_charters'] > 0 ) {
		$tower['fuel_charters'] = number_format($tower['fuel_charters']);
		} else {
		$tower['fuel_charters'] = '';
		}
		
		if ($tower['fuel_A_fuelblock'] > 0 ) {
		$tower['fuel_A_fuelblock'] = number_format($tower['fuel_A_fuelblock']);
		}
		
		if ($tower['fuel_M_fuelblock'] > 0 ) {
		$tower['fuel_M_fuelblock'] = number_format($tower['fuel_M_fuelblock']);
		}
		
		if ($tower['fuel_C_fuelblock'] > 0 ) {
		$tower['fuel_C_fuelblock'] = number_format($tower['fuel_C_fuelblock']);
		}
		
		if ($tower['fuel_G_fuelblock'] > 0 ) {
		$tower['fuel_G_fuelblock'] = number_format($tower['fuel_G_fuelblock']);
		}
		
        $disp_towers[$key] = $tower;
    }
	$fuel_total = ceil($fuel_A_total / 40) + ceil($fuel_M_total / 40) + ceil($fuel_C_total / 40) + ceil($fuel_G_total / 40);
	$fuel_time = ($fuel_total * 4) / 60;
	$fuel_uranium = $fuel_total * 4;
	$fuel_oxygen = $fuel_total * 20;
	$fuel_mechanical_parts = $fuel_total * 4;
	$fuel_coolant = $fuel_total * 8;
	$fuel_robotics = $fuel_total * 1;
	$fuel_ozone = $fuel_total * 150;
	$fuel_heavy_water = $fuel_total * 150;
	$fuel_H_isotopes = ceil($fuel_A_total / 40) * 400;
	$fuel_N_isotopes = ceil($fuel_C_total / 40) * 400;
	$fuel_O_isotopes = ceil($fuel_G_total / 40) * 400;
	$fuel_Hy_isotopes = ceil($fuel_M_total / 40) * 400;
	
    $fuel_uranium_size          = $fuel_uranium           * $pos_Ura;
    $fuel_oxygen_size           = $fuel_oxygen            * $pos_Oxy;
    $fuel_mechanical_parts_size = $fuel_mechanical_parts  * $pos_Mec;
    $fuel_coolant_size          = $fuel_coolant           * $pos_Coo;
    $fuel_robotics_size         = $fuel_robotics          * $pos_Rob;
    $fuel_ozone_size            = $fuel_ozone             * $pos_Ozo;
    $fuel_heavy_water_size      = $fuel_heavy_water       * $pos_Hea;
	$fuel_H_isotopes_size       = $fuel_H_isotopes        * $pos_Iso;
    $fuel_N_isotopes_size       = $fuel_N_isotopes        * $pos_Iso;
    $fuel_O_isotopes_size       = $fuel_O_isotopes        * $pos_Iso;
    $fuel_Hy_isotopes_size      = $fuel_Hy_isotopes       * $pos_Iso;
	
	$prices = $posmgmt->GetPrices();
	$amarrFB_cost = $prices['Amarr Fuel Block'] * $fuel_A_total;
	$minmatarFB_cost = $prices['Minmatar Fuel Block'] * $fuel_M_total;
	$caldariFB_cost = $prices['Caldari Fuel Block'] * $fuel_C_total;
	$gallenteFB_cost = $prices['Gallente Fuel Block'] * $fuel_G_total;	
	$uranium_cost = $prices['Enriched Uranium'] * $fuel_uranium;
	$oxygen_cost = $prices['Oxygen'] * $fuel_oxygen;
	$mechanical_parts_cost = $prices['Mechanical Parts'] * $fuel_mechanical_parts;
	$coolant_cost = $prices['Coolant'] * $fuel_coolant;
	$robotics_cost = $prices['Robotics'] * $fuel_robotics;
	$helium_iso_cost = $prices['Helium Isotopes'] * $fuel_H_isotopes;
	$hydrogen_iso_cost = $prices['Hydrogen Isotopes'] * $fuel_Hy_isotopes;
	$nitrogen_iso_cost = $prices['Nitrogen Isotopes'] * $fuel_N_isotopes;
	$oxygen_iso_cost = $prices['Oxygen Isotopes'] * $fuel_O_isotopes;
	$liquid_ozone_cost = $prices['Liquid Ozone'] * $fuel_ozone;
	$heavy_water_cost = $prices['Heavy Water'] * $fuel_heavy_water;
	
	$fuel_A_total_size = number_format($fuel_A_total * $pos_Fbl);
	$fuel_M_total_size = number_format($fuel_M_total * $pos_Fbl);
	$fuel_C_total_size = number_format($fuel_C_total * $pos_Fbl);
	$fuel_G_total_size = number_format($fuel_G_total * $pos_Fbl);
	$charter_total_size = $charter_total * $pos_Cha;
	$fuel_A_total = number_format($fuel_A_total);
	$fuel_M_total = number_format($fuel_M_total);
	$fuel_C_total = number_format($fuel_C_total);
	$fuel_G_total = number_format($fuel_G_total);
	$charter_total = number_format($charter_total);
	$fuel_uranium = number_format($fuel_uranium);
	$fuel_oxygen = number_format($fuel_oxygen);
	$fuel_mechanical_parts = number_format($fuel_mechanical_parts);
	$fuel_coolant = number_format($fuel_coolant);
	$fuel_robotics = number_format($fuel_robotics);
	$fuel_ozone = number_format($fuel_ozone);
	$fuel_heavy_water = number_format($fuel_heavy_water);
	$fuel_H_isotopes = number_format($fuel_H_isotopes);
	$fuel_N_isotopes = number_format($fuel_N_isotopes);
	$fuel_O_isotopes = number_format($fuel_O_isotopes);
	$fuel_Hy_isotopes = number_format($fuel_Hy_isotopes);
	
	$fb_total_cost = $amarrFB_cost + $minmatarFB_cost + $caldariFB_cost + $gallenteFB_cost;
	
	$total_cost = $uranium_cost + $oxygen_cost + $mechanical_parts_cost + $coolant_cost + $robotics_cost + $helium_iso_cost + $hydrogen_iso_cost + $nitrogen_iso_cost + $oxygen_iso_cost + $liquid_ozone_cost + $heavy_water_cost;
	
    $total_size = $fuel_uranium_size + $fuel_oxygen_size + $fuel_mechanical_parts_size + $fuel_coolant_size + $fuel_robotics_size + $fuel_H_isotopes_size + $fuel_N_isotopes_size + $fuel_O_isotopes_size + $fuel_Hy_isotopes_size + $fuel_ozone_size + $fuel_heavy_water_size;

	$eveRender->Assign('uranium_cost', $uranium_cost);
	$eveRender->Assign('oxygen_cost', $oxygen_cost);
	$eveRender->Assign('mechanical_parts_cost', $mechanical_parts_cost);
	$eveRender->Assign('coolant_cost', $coolant_cost);
	$eveRender->Assign('robotics_cost', $robotics_cost);
	$eveRender->Assign('helium_iso_cost', $helium_iso_cost);
	$eveRender->Assign('hydrogen_iso_cost', $hydrogen_iso_cost);
	$eveRender->Assign('nitrogen_iso_cost', $nitrogen_iso_cost);
	$eveRender->Assign('oxygen_iso_cost', $oxygen_iso_cost);
	$eveRender->Assign('liquid_ozone_cost', $liquid_ozone_cost);
	$eveRender->Assign('heavy_water_cost', $heavy_water_cost);
	$eveRender->Assign('total_cost', $total_cost);
	$eveRender->Assign('fb_total_cost', $fb_total_cost);
    $eveRender->Assign('fuel_uranium_size',           $fuel_uranium_size);
    $eveRender->Assign('fuel_oxygen_size',            $fuel_oxygen_size);
    $eveRender->Assign('fuel_mechanical_parts_size',  $fuel_mechanical_parts_size);
    $eveRender->Assign('fuel_coolant_size',           $fuel_coolant_size);
    $eveRender->Assign('fuel_robotics_size',          $fuel_robotics_size);
    $eveRender->Assign('fuel_H_isotopes_size',        $fuel_H_isotopes_size);
    $eveRender->Assign('fuel_N_isotopes_size',        $fuel_N_isotopes_size);
    $eveRender->Assign('fuel_O_isotopes_size',        $fuel_O_isotopes_size);
    $eveRender->Assign('fuel_N_isotopes_size',        $fuel_N_isotopes_size);
    $eveRender->Assign('fuel_Hy_isotopes_size',       $fuel_Hy_isotopes_size);
    $eveRender->Assign('fuel_Hy_isotopes_size',       $fuel_Hy_isotopes_size);
    $eveRender->Assign('fuel_ozone_size',             $fuel_ozone_size);
    $eveRender->Assign('fuel_heavy_water_size',       $fuel_heavy_water_size);
    $eveRender->Assign('fuel_H_isotopes',             $fuel_H_isotopes);
    $eveRender->Assign('fuel_N_isotopes',             $fuel_N_isotopes);
    $eveRender->Assign('fuel_O_isotopes',             $fuel_O_isotopes);
    $eveRender->Assign('fuel_Hy_isotopes',            $fuel_Hy_isotopes);
    $eveRender->Assign('fuel_uranium',                $fuel_uranium);
    $eveRender->Assign('fuel_oxygen',                 $fuel_oxygen);
    $eveRender->Assign('fuel_uranium',                $fuel_uranium);
    $eveRender->Assign('fuel_mechanical_parts',       $fuel_mechanical_parts);
    $eveRender->Assign('fuel_coolant',                $fuel_coolant);
    $eveRender->Assign('fuel_robotics',               $fuel_robotics);
    $eveRender->Assign('fuel_ozone',                  $fuel_ozone);
    $eveRender->Assign('fuel_heavy_water',            $fuel_heavy_water);
    $eveRender->Assign('total_size',                  $total_size);
	$eveRender->Assign('fuel_A_total_size',        $fuel_A_total_size);
    $eveRender->Assign('fuel_C_total_size',        $fuel_C_total_size);
    $eveRender->Assign('fuel_G_total_size',        $fuel_G_total_size);
    $eveRender->Assign('fuel_M_total_size',        $fuel_M_total_size);
	$eveRender->Assign('fuel_A_total',				  $fuel_A_total);
    $eveRender->Assign('fuel_C_total',		          $fuel_C_total);
    $eveRender->Assign('fuel_G_total',        		 $fuel_G_total);
    $eveRender->Assign('fuel_M_total',        		 $fuel_M_total);
	$eveRender->Assign('fuel_time',        		 $fuel_time);
	$eveRender->Assign('amarrFB_cost',			 $amarrFB_cost);
    $eveRender->Assign('caldariFB_cost',		     $caldariFB_cost);
    $eveRender->Assign('gallenteFB_cost',      	 $gallenteFB_cost);
    $eveRender->Assign('minmatarFB_cost',    	 $minmatarFB_cost);
	$eveRender->Assign('charter_total_size',             $charter_total_size);
	$eveRender->Assign('charter_total',             $charter_total);
	$eveRender->Assign('fb_total_size',             $fb_total_size);
    $eveRender->Assign('towers',                      $disp_towers);
	$eveRender->Assign('towerName',                   $towerName);
    $eveRender->Display('fuelbill.tpl');

} else {

  $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
  $eve->RedirectUrl('track.php');

}
?>
