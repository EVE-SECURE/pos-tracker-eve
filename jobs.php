<?php

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

$eve_id = $eve->SessionGetVar('eve_id');
$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo', $userinfo);
$user_id = $_SESSION['delsid'];

if (in_array('1', $access) && (in_array('40', $access) || in_array('41', $access) || in_array('45', $access)) || in_array('5', $access)) {

	$jobs = $posmgmt->GetAllIndustrialJobs();
	$itemDB = $posmgmt->GetAllStaticItems();
	
	
	foreach ($jobs as $key => $value) {
	
		foreach ($value as $k => $v) {

			if ($k == 'installedItemTypeID') {
				foreach($itemDB as $key2 => $value2) {
					foreach ($value2 as $k2 => $v2) {
						if ($k2 == 'typeID') {
							if ($v == $v2) {
								$jobs[$key][$k] = $itemDB[$key2]['typeName'];
							}
						}
					}
				}
			}
			
			if ($k == 'containerTypeID') {
				foreach($itemDB as $key2 => $value2) {
					foreach ($value2 as $k2 => $v2) {
						if ($k2 == 'typeID') {
							if ($v == $v2) {
								$jobs[$key][$k] = $itemDB[$key2]['typeName'];
							}
						}
					}
				}
			}
			
			if ($k == 'outputTypeID') {
				foreach($itemDB as $key2 => $value2) {
					foreach ($value2 as $k2 => $v2) {
						if ($k2 == 'typeID') {
							if ($v == $v2) {
								$jobs[$key][$k] = $itemDB[$key2]['typeName'];
							}
						}
					}
				}
			}
			
		}
	}
	   
/*
	foreach ($jobs as $key => $value) {
		foreach ($value as $k => $v) {
			if ($k == 'containerTypeID') {
				foreach($itemDB as $key2 => $value2) {
					foreach ($value2 as $k2 => $v2) {
						if ($k2 == 'typeID') {
							if ($v == $v2) {
								$jobs[$key][$k] = $itemDB[$key2]['typeName'];
							}
						}
					}
				}
			}
		}
	}
	
*/
	
	$activ = array(0  => 'None',
					   1  => 'Manufacturing',
                       2  => 'Researching Technology',
                       3  => 'Time Efficiency Reseach',
                       4  => 'Material Research',
                       5  => 'Copying',
                       6  => 'Duplicating',
                       7  => 'Reverse Engineering',
                       8  => 'Invention');
					   
	$eveRender->Assign('jobs', $jobs);
	$eveRender->Assign('count', $count);
	$eveRender->Assign('counts', $counts);
	$eveRender->Assign('activ', $activ);
    $eveRender->Display('jobs.tpl');
} else {
	$eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
	$eve->RedirectUrl('track.php');
}

?>
