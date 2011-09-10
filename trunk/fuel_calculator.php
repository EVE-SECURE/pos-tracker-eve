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
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

$pos_to_refuel = $eve->VarCleanFromInput('pos_to_refuel');

$optlevels = array(1 => 'Current Level - Yes', 0 => 'Current Level - No');
$disopt = array(1 => 'Display Optimals - Yes', 0 => 'Display Optimals - No');
$partialopt = array(0 => 'Partial Fuelup - No', 1 => 'Partial Fuelup - Yes');

$eveRender->Assign('optlevels', $optlevels);
$eveRender->Assign('disopt', $disopt);
$eveRender->Assign('partialopt', $partialopt);

if (!empty($pos_to_refuel)) {
    $days               = $eve->VarCleanFromInput('days');
    $hours              = $eve->VarCleanFromInput('hours');
    $use_current_levels = $eve->VarCleanFromInput('use_current_levels');
	$display_optimal	= $eve->VarCleanFromInput('display_optimal');
	$partial_fuelup	= $eve->VarCleanFromInput('partial_fuelup');
    $use_hanger_levels  = 0;//$eve->VarCleanFromInput('use_hanger_levels');
    $cargosize          = $eve->VarCleanFromInput('size');
	
    $args['days_to_refuel']     = $days + ($hours/24);
    $args['pos_ids'][]          = $pos_to_refuel;
    $args['use_current_levels'] = $use_current_levels;
	$args['display_optimal'] = $display_optimal;
	$args['calc_fuel'] = 1;
    $bill = $posmgmt->GetFuelBill($args);
	
    $tower = $bill[$pos_to_refuel];

    $required_H_isotope  = 0;
    $required_N_isotope  = 0;
    $required_O_isotope  = 0;
    $required_Hy_isotope = 0;

    $system                   = $tower['system'];
    $pos_id                   = $tower['pos_id'];
    $pos_race                 = $tower['pos_race'];
    $locationName             = $tower['locationName'];
	
    $tower['regionName']      = $posmgmt->getRegionNameFromMoonID($locationName);

    switch($pos_race) {
        case 1:  $required_H_isotope  = $tower['needed_isotopes']; break;
        case 6:  $required_H_isotope  = $tower['needed_isotopes']; break;
        case 7:  $required_H_isotope  = $tower['needed_isotopes']; break;
        case 11: $required_H_isotope  = $tower['needed_isotopes']; break;
        case 14: $required_H_isotope  = $tower['needed_isotopes']; break;
        case 4:  $required_Hy_isotope = $tower['needed_isotopes']; break;
        case 5:  $required_Hy_isotope = $tower['needed_isotopes']; break;
        case 8:  $required_Hy_isotope = $tower['needed_isotopes']; break;
        case 2:  $required_N_isotope  = $tower['needed_isotopes']; break;
        case 9:  $required_N_isotope  = $tower['needed_isotopes']; break;
        case 10: $required_N_isotope  = $tower['needed_isotopes']; break;
        case 3:  $required_O_isotope  = $tower['needed_isotopes']; break;
        case 12: $required_O_isotope  = $tower['needed_isotopes']; break;
        case 13: $required_O_isotope  = $tower['needed_isotopes']; break;
    }
    $tower['required_H_isotope']  = $required_H_isotope;
    $tower['required_Hy_isotope'] = $required_Hy_isotope;
    $tower['required_N_isotope']  = $required_N_isotope;
    $tower['required_O_isotope']  = $required_O_isotope;

	if ($tower['required_H_isotope'] > 1) {
	$race_isotope = "Helium";
	} elseif ($tower['required_Hy_isotope'] > 1) { 
	$race_isotope = "Hydrogen";
	} elseif ($tower['required_N_isotope'] > 1) { 
	$race_isotope = "Nitrogen";
	} elseif ($tower['required_O_isotope'] > 1) { 
	$race_isotope = "Oxygen"; }

	$fuel = $tower;

    if($cargosize > 0) {
        $fuel['trips'] = ceil($fuel['total_volume'] / $cargosize);
    }

	if ($display_optimal == 1) {
		$tower = $posmgmt->GetTowerInfo($pos_to_refuel);

		if ($tower) {
			$pos_size                = $tower['pos_size'];
            $pos_race                = $tower['pos_race'];
			$tower_pg                = $tower['powergrid'];
            $tower_cpu               = $tower['cpu'];
			$systemID                = $tower['systemID'];
            $location                = $tower['moonName'];
			$tower['sovereignty']    = $posmgmt->getSovereignty($systemID);
			$allianceid              = $tower['allianceid'];
            $tower['sovfriendly']    = $posmgmt->getSovereigntyStatus($systemID, $allianceid);
		}
	
		$db = $posmgmt->selectstaticdb($systemID, $allianceid);
	
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
            $tower['race_isotope']               = $row['race_isotope'];
            $tower['total_pg']                   = $row['pg'];
            $tower['total_cpu']                  = $row['cpu'];
            $total_pg                            = $row['pg'];
            $total_cpu                           = $row['cpu'];
			$tower['pos_capacity']=$tower['fuel_hangar']=$row['fuel_hangar'];
        }
	
		if($current_cpu<=0 && $tower['cpu']>0) {
            $current_cpu=$tower_cpu;
        }
		if($current_pg<=0 && $tower_pg>0) {
            $current_pg=$tower_pg;
        }
		
		$tower['current_pg']  = $current_pg;
		$tower['current_cpu'] = $current_cpu;
		
		
		$optimal=$posmgmt->posoptimaluptime($tower);
		$optimalDiff=$posmgmt->getOptimalDifference($optimal, $tower);
	
		if ($partial_fuelup == 1) {
			$tower['fuel_hangar']=$cargosize;
			$partial_optimal=$posmgmt->posoptimaluptime($tower);
			$partial_optimal['total']=(($partial_optimal['optimum_uranium']*$pos_Ura)+($partial_optimal['optimum_oxygen']*$pos_Oxy)+($partial_optimal['optimum_mechanical_parts']*$pos_Mec)+
			($partial_optimal['optimum_coolant']*$pos_Coo)+($partial_optimal['optimum_robotics']*$pos_Rob)+($partial_optimal['optimum_isotope']*$pos_Iso)+
			($partial_optimal['optimum_ozone']*$pos_Ozo)+($partial_optimal['optimum_heavy_water']*$pos_Hea));
			if ($tower['charters_needed'] == 1) {
			$partial_optimal['total']=($partial_optimal['total']+($partial_optimal['optimum_charters']*$pos_Cha));
			}
		}
	if($cargosize > 0) {
       $fuel['trips2'] = ceil($optimalDiff['totalDiff'] / $cargosize);
    }
	
	$eveRender->Assign('optimal',   $optimal);
    $eveRender->Assign('optimalDiff',   $optimalDiff);
	$eveRender->Assign('partial_optimal',   $partial_optimal);
}

	$eveRender->Assign('pos_id',           $pos_id);
	$eveRender->Assign('race_isotope',           $race_isotope);
    $eveRender->Assign('fuel',           $fuel);
    $eveRender->Assign('hours',          $hours);
    $eveRender->Assign('cargosize',      $cargosize);
    $eveRender->Assign('pos_to_refuel',  $pos_to_refuel);
    $eveRender->Assign('days_to_refuel', $args['days_to_refuel']);	
	$eveRender->Assign('display_optimal',   $display_optimal);
	$eveRender->Assign('use_current_levels',   $use_current_levels);
	$eveRender->Assign('partial_fuelup',   $partial_fuelup);
}

$towers = $posmgmt->GetAllPos2();
$opttowers[0] = 'POS List';
foreach ($towers as $tower) {
    $opttowers[$tower['pos_id']] = $tower['MoonName'] . ' - ' . $tower['towerName'];
}

$eveRender->Assign('opttowers', $opttowers);
$eveRender->Display('fuel_calc.tpl');
exit;

?>
