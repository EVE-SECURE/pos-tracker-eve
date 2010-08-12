<?php

include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';
include_once 'eveconfig/config.php';
$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);
$access = $eve->SessionGetVar('access');
if ( $access >= 2 ) {
	$eveRender->Assign('access', $access);
} else {
    $eve->SessionSetVar('errormsg', 'Access Denied - Please login!');
    $eve->RedirectUrl('login.php');
}

$pos_id = $eve->VarCleanFromInput('i');

if (!$pos_id) {
    $eve->SessionSetVar('errormsg', 'Need an ID!');
    $eve->RedirectUrl('index.php');
}

$pos = $posmgmt->GetTowerInfo($pos_id);

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

$pos['pos_type_name'] = $arrporace[$pos['pos_race']];
$pos['pos_size_name'] = $arrposize[$pos['pos_size']];

//echo '<pre>';print_r($pos); echo '</pre>';exit;
if (!$pos) {
    $eve->SessionSetVar('errormsg', 'That POS apparently does not exist!');
    $eve->RedirectUrl('track.php');
}

$action = $eve->VarCleanFromInput('action');

if ($action == 'deletepos') {
    if ($access <= 2) {
	if ($access == 2 && ($pos['owner_id'] == $userinfo['eve_id'] || $pos['secondary_owner_id'] == $userinfo['eve_id'])) {
		if ($posmgmt->DeletePOS($pos_id)) {
	        	$eve->SessionSetVar('statusmsg', 'POS deleted!');
		        $eve->RedirectUrl('track.php');
		}
	} else {
	        $eve->SessionSetVar('statusmsg', 'ERROR - You are not allowed to delete this POS');
		$eve->RedirectUrl('track.php');
	}
    } elseif ($posmgmt->DeletePOS($pos_id)) {
        $eve->SessionSetVar('statusmsg', 'POS deleted!');
        $eve->RedirectUrl('track.php');
    }
}

$eveRender->Assign($pos);
$eveRender->Display('deletepos.tpl');


?>
