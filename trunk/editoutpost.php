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
$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array(61, $access) && !in_array('5', $access) && !in_array('6', $access)) {
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

$action = $eve->VarCleanFromInput('action');
switch($action) {
    case 'Update Outpost Hangar':

		$fuel['uranium']         = $eve->VarCleanFromInput('uranium');
		$fuel['oxygen']          = $eve->VarCleanFromInput('oxygen');
		$fuel['mechanical_parts']= $eve->VarCleanFromInput('mechanical_parts');
		$fuel['coolant']         = $eve->VarCleanFromInput('coolant');
		$fuel['robotics']        = $eve->VarCleanFromInput('robotics');
		$fuel['heisotope']       = $eve->VarCleanFromInput('heisotope');
		$fuel['hyisotope']       = $eve->VarCleanFromInput('hyisotope');
		$fuel['oxisotope']       = $eve->VarCleanFromInput('oxisotope');
		$fuel['niisotope']       = $eve->VarCleanFromInput('niisotope');
		$fuel['ozone']           = $eve->VarCleanFromInput('ozone');
		$fuel['heavy_water']     = $eve->VarCleanFromInput('heavy_water');
		$fuel['strontium']       = $eve->VarCleanFromInput('strontium');
		$fuel['charters']        = $eve->VarCleanFromInput('charters');
		$fuel['outpost_id']      = $outpost_id;
        if ($posmgmt->UpdateOutpostFuel($fuel)) {
            $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
            $eve->RedirectUrl('viewoutpost.php?i='.$outpost_id);
        }
        break;
}

//Gather Outpost Data
$outpost = $posmgmt->GetOutpostInfo($outpost_id);
$hoursago = $posmgmt->hoursago($outpost_id, '4');
$update = $posmgmt->GetLastOutpostUpdate($outpost_id);
$outpost['hoursago']=$hoursago;
$outpost['lastupdate'] = gmdate("Y-m-d H:i:s", $update['datetime']);

//Assign Outpost Data to template
$eveRender->Assign('outpost',   $outpost);

//Display template
$eveRender->Display('editoutpost.tpl');

?>