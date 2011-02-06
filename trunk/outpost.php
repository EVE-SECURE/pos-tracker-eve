<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
//echo '<pre>';print_r($config); echo '</pre>';exit;
$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (in_array('1', $access) || in_array('5', $access)) {

	$outposts = $posmgmt->GetAllOutpost();

	foreach($outposts as $key => $row) {
		$row['outpostuptime']=$posmgmt->outpostUptimeCalc($row['outpost_id']);
		$update = $posmgmt->GetLastOutpostUpdate($row['outpost_id']);
		$row['lastupdate'] = gmdate("Y-m-d H:i:s", $update['datetime']);
		$row['outpostonline']=$posmgmt->outpost_online($row['outpostuptime']);
		$row['outpostdaycalc']=$posmgmt->daycalc($row['outpostonline']);
		$outposts[$key] = $row;
	}

	$eveRender->Assign('config',    $config);
	$eveRender->Assign('outposts',     $outposts);
		
	$eveRender->Display('outpost.tpl');
} else {

  $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
  $eve->RedirectUrl('track.php');

}

