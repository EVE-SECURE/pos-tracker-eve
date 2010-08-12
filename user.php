<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
/*$colors    = $eveRender->themeconfig;*/
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eveinfo  = $eve->GetUserVars();
$userinfo = array_merge($userinfo, $eveinfo);

if (!$userinfo) {
    $eve->RedirectUrl('register.php');
}

$IS_IGB = $eve->IsMiniBrowser();

if (!$userinfo['access']) {
    $eve->SessionSetVar('errormsg', 'You don\'t have access to this tracker!');
    $eve->RedirectUrl('index.php');
}

$action = $eve->VarCleanFromInput('action');

if ($action == 'changeinfo') {
	$theme_id = $eve->VarCleanFromInput('theme_id');
    $away     = $eve->VarCleanFromInput('away');
    $email    = $eve->VarCleanFromInput('email');
    $newpass  = $eve->VarCleanFromInput('newpass');
    $newpass2 = $eve->VarCleanFromInput('newpass2');

	if (!empty($theme_id) && $theme_id != $userinfo['theme_id']) {
      if ($posmgmt->UpdateUserTheme(array('id' => $userinfo['id'], 'newtheme' => $theme_id))) {
         $eve->SessionSetVar('statusmsg', 'New theme set!');
         $eve->RedirectUrl('user.php');
      }
    }
	
    if (!empty($away) && $away != $userinfo['away']) {
      if ($posmgmt->UpdateUserAway(array('id' => $userinfo['id'], 'newaway' => $away))) {
         $eve->SessionSetVar('statusmsg', 'New away status saved!');
         $eve->RedirectUrl('user.php');
      }
    }

    if (!empty($email) && $email != $userinfo['email']) {
        if ($posmgmt->UpdateUserMail(array('id' => $userinfo['id'], 'newmail' => $email))) {
            $eve->SessionSetVar('statusmsg', 'New email address saved!');
            $eve->RedirectUrl('user.php');
        }
    }

    if (!empty($newpass) && $newpass != $newpass2) {
        $eve->SessionSetVar('errormsg', 'Pass and Confirmation pass are different. Get it right, nugget!');
        $eve->RedirectUrl('user.php');
    }

    if ($newpass) {
        if (!$posmgmt->UpdateUserPass(array('id' => $userinfo['id'], 'newpass' => $newpass))) {
            $eve->RedirectUrl('user.php');
        }
        $eve->SessionSetVar('statusmsg', 'New password saved!');
        $eve->RedirectUrl('user.php');
    }
}

if ($action == 'updatecorpinfo') {
    if ($posmgmt->UpdateUserInfo($userinfo)) {
        $eve->SessionSetVar('statusmsg', 'Your information has been saved!');
        $eve->RedirectUrl('user.php');
    }
}

$eveRender->Assign($userinfo);
$eveRender->Assign('awaystatus', array( 2 => 'No', 1 => 'Yes'));
$eveRender->Assign('themeset', array( 1 => 'FGV - Default', 2 => 'Original POS-Tracker', 3 => 'Majesta Empire', 4 => 'Razor Alliance', 5 => 'Morsus Mihi'));
$eveRender->Assign('IS_IGB', $IS_IGB);

$eveRender->Display('user.tpl');

?>
