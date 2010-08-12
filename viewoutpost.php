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

if ($access < 3) {
        $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
        $eve->RedirectUrl('outpost.php');
}

$eveRender->Assign('access', $access);

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

//Assign Outpost Data to template
$eveRender->Assign('outpost',   $outpost);
$eveRender->Assign('outpost_req',   $outpost_req);
$eveRender->Assign('towers',   $towers);


//Display template
$eveRender->Display('viewoutpost.tpl');

?>
