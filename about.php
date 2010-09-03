<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';
$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);
$eveRender->Assign('access', $userinfo['access']);
$eveRender->Assign('config', $config);

$version = '5.0.3 FGV';//$posmgmt->GetVersion();

$eveRender->Assign('version', $version);

$eveRender->Display('about.tpl');

?>