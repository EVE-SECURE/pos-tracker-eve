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

$pID = 'fuelcalc';
$eveRender->Assign('pID', $pID);

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

    $system                   = $tower['system'];
    $pos_id                   = $tower['pos_id'];
    $pos_race                 = $tower['pos_race'];
    $locationName             = $tower['locationName'];
	
    $tower['regionName']      = $posmgmt->getRegionNameFromMoonID($locationName);

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
			$charters_needed         = $tower['charters_needed'];
		}
	
        $row = $posmgmt->GetStaticFBTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size));
		if ($tower['sovfriendly'] == 1) {
			$tower['hasSov'] = .75;
		} else {
			$tower['hasSov'] = 1;
		}
		
        if ($row) {
			$tower['required_fuelblock']         = ceil($row['fuelblock'] * $tower['hasSov']);
            $tower['required_strontium']         = ceil($row['strontium'] * $tower['hasSov']);
            $tower['required_charters']          = $charters_needed?1:0;
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
			$partial_optimal['total']=($partial_optimal['optimum_fuelblock']*$pos_Fbl);
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
