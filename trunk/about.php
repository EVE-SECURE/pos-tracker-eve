<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';
include_once 'version.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;

$eve     = New Eve();
$posmgmt = New POSMGMT();
$userinfo = $posmgmt->GetUserInfo();

$pID = 'about';
$eveRender->Assign('pID', $pID);

$theme_id = $eve->SessionGetVar('theme_id');
$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('theme_id', $theme_id);
$eveRender->Assign('access', $access);
$eveRender->Assign('config', $config);
$eveRender->Assign('version', VERSION);
$eveRender->Display('about.tpl');
?>