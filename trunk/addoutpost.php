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

if (!in_array('1', $access) || !in_array('5', $access)) {
        $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
        $eve->RedirectUrl('outpost.php');
}


$action = $eve->VarCleanFromInput('action');
switch($action) {
    case 'Add Outpost':
		$fuel['corp']           = $userinfo['corp'];
		$fuel['outpost_name']	= $eve->VarCleanFromInput('outpostName');
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
        if ($posmgmt->AddNewOutpost($fuel)) {
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
$eveRender->Display('addoutpost.tpl');

?>
