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

$pID = 'jobs';
$eveRender->Assign('pID', $pID);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo', $userinfo);

$submit = $eve->VarCleanFromInput('submit');
$completed = $eve->VarCleanFromInput('completed');
$settings = $posmgmt->GetSettings();

if (in_array('5', $access) || in_array('6', $access)) {
$ignore = 0;
} elseif ($settings[0]['gsetting'] == '') {
$ignore = 0;
} elseif ($settings[0]['gsetting'] >= 0  || $settings[0]['gsetting'] <= 3) {
$ignore = $settings[0]['gsetting'];
}

if (in_array('1', $access) && (in_array('40', $access) || in_array('41', $access) || in_array('45', $access)) || in_array('5', $access) || in_array('6', $access)) {

	if (!empty($submit)) {
		if ($completed == 1 && (in_array('41', $access) || in_array('45', $access) || in_array('5', $access) || in_array('6', $access))) {
		$jobs = $posmgmt->GetAllIndustrialJobs(1,$ignore);
		
		} else {
		$jobs = $posmgmt->GetAllIndustrialJobs(0,$ignore);				
		}
	} else {
	$jobs = $posmgmt->GetAllIndustrialJobs(0,$ignore);
	}

	$activ = array(0  => 'None',
					   1  => 'Manufacturing',
                       2  => 'Researching Technology',
                       3  => 'Time Efficiency Reseach',
                       4  => 'Material Research',
                       5  => 'Copying',
                       6  => 'Duplicating',
                       7  => 'Reverse Engineering',
                       8  => 'Invention');
					   
	$eveRender->Assign('completed', $completed);		   
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
