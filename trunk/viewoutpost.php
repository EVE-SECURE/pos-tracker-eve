<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array('60', $access) && !in_array(61, $access)
	&& !in_array('5', $access) && !in_array('6', $access)) {
        $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
        $eve->RedirectUrl('outpost.php');
}

$outpost_id = $eve->VarCleanFromInput('i');
// Dirty fix
if (empty($outpost_id)) {
    $outpost_id = $eve->VarCleanFromInput('outpost_id');
}
if (empty($outpost_id)) {
    $eve->SessionSetVar('errormsg', 'No Outpost ID!');
    $eve->RedirectUrl('track.php');
}
if (!is_numeric($outpost_id)) {
    $eve->SessionSetVar('errormsg', 'Incorrect Outpost ID!');
    $eve->RedirectUrl('track.php');
}

// TODO: Make this configurable via the UI
$daysToStock = 60;

$action = $eve->VarCleanFromInput('action');

//Gather Outpost Data
$outpost = $posmgmt->GetOutpostInfo($outpost_id);
$uptime=$posmgmt->outpostUptimeCalc($outpost_id);
$outpost_req=$posmgmt->outpostRequired($outpost_id);
$hoursago = $posmgmt->hoursago($outpost_id, '4');
$update = $posmgmt->GetLastOutpostUpdate($outpost_id);
$outpost['hoursago']=$hoursago;
$outpost['lastupdate'] = gmdate("Y-m-d H:i:s", $update['datetime']);
$outpost['uptimecalc']=$uptime;
$poslist=$posmgmt->GetAllPosOutpost($outpost_id);

$towers=array();
foreach($poslist as $tower)
{
		$tower['moonName']=$posmgmt->getMoonNameFromMoonID($tower['moonID']);
		$towerstatic=$posmgmt->GetTowerType($tower['typeID']);
		$tower['typeName']=$towerstatic['typeName'];
		
		$towers[]=$tower;
		
		
}

$desiredStock = array(
		'uranium' => (($outpost_req['uranium'] * ($daysToStock * 24)) - $outpost['uranium']),
		'oxygen' => (($outpost_req['oxygen'] * ($daysToStock * 24)) - $outpost['oxygen']),
		'mechanical_parts' => (($outpost_req['mechanical_parts'] * ($daysToStock * 24)) - $outpost['mechanical_parts']),
		'coolant' => (($outpost_req['coolant'] * ($daysToStock * 24)) - $outpost['coolant']),
		'robotics' => (($outpost_req['robotics'] * ($daysToStock * 24)) - $outpost['robotics']),
		'heisotope' => (($outpost_req['heisotope'] * ($daysToStock * 24)) - $outpost['heisotope']),
		'hyisotope' => (($outpost_req['hyisotope'] * ($daysToStock * 24)) - $outpost['hyisotope']),
		'oxisotope' => (($outpost_req['oxisotope'] * ($daysToStock * 24)) - $outpost['oxisotope']),
		'niisotope' => (($outpost_req['niisotope'] * ($daysToStock * 24)) - $outpost['niisotope']),
		'ozone' => (($uptime['total_needed_ozone'] * ($daysToStock * 24)) - $outpost['ozone']),
		'heavy_water' => (($uptime['total_needed_heavy_water'] * ($daysToStock * 24)) - $outpost['heavy_water']),
		);

//Assign Outpost Data to template
$eveRender->Assign('outpost',   $outpost);
$eveRender->Assign('outpost_req',   $outpost_req);
$eveRender->Assign('towers',   $towers);
$eveRender->assign('daysToStock', $daysToStock);
$eveRender->Assign('desiredStock', $desiredStock);


//Display template
$eveRender->Display('viewoutpost.tpl');

?>
