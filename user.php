<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
if (!$userinfo) {
    $eve->RedirectUrl('register.php');
}

$IS_IGB = $eve->IsMiniBrowser();

if (!$userinfo['access'] || in_array('-1', $access)) {
    $eve->SessionSetVar('errormsg', 'You don\'t have access to this tracker!');
    $eve->RedirectUrl('index.php');
}

$action = $eve->VarCleanFromInput('action');

if ($action == 'changeinfo') {
	$theme_id = $eve->VarCleanFromInput('theme_id');
	$user_track_display = $eve->VarCleanFromInput('user_track_display');
	$user_track_sort = $eve->VarCleanFromInput('user_track_sort');
	$trackArray = array($user_track_display, $user_track_sort);
	$user_track = implode(".",array_filter($trackArray));
    $away     = $eve->VarCleanFromInput('away');
    $email    = $eve->VarCleanFromInput('email');
    $newpass  = $eve->VarCleanFromInput('newpass');
    $newpass2 = $eve->VarCleanFromInput('newpass2');

	if ($posmgmt->UpdateUserSettings(array('id' => $userinfo['id'], 'newtheme' => $theme_id, 'new_user_track' => $user_track, 'newaway' => $away))) {
         $eve->SessionSetVar('statusmsg', 'User Settings Updated!');
         $eve->RedirectUrl('user.php');
      }

    if (!empty($email) && $email != $userinfo['email']) {
        if ($posmgmt->UpdateUserMail(array('id' => $userinfo['id'], 'newmail' => $email))) {
            $eve->SessionSetVar('statusmsg', 'New email address saved!');
            $eve->RedirectUrl('user.php');
        }
    }

    if (!empty($newpass) && $newpass != $newpass2) {
        $eve->SessionSetVar('errormsg', 'Password and Confirmation pass are different!');
        $eve->RedirectUrl('user.php');
    }

    if ($newpass) {
        if (!$posmgmt->UpdateUserPass(array('id' => $userinfo['id'], 'newpass' => $newpass))) {
            $eve->RedirectUrl('user.php');
        }
        $eve->SessionSetVar('statusmsg', 'New password saved!');
        $eve->RedirectUrl('user.php');
    }
	$userinfo = $posmgmt->GetUserInfo();
}

if ($action == 'updatecorpinfo') {
	$eveinfo  = $eve->GetUserVars();
	$userinfo = array_merge($userinfo, $eveinfo);
    if ($posmgmt->UpdateUserInfo($userinfo)) {
        $eve->SessionSetVar('statusmsg', 'Your information has been saved!');
        $eve->RedirectUrl('user.php');
    }
}

$user_track_sort = array(
	11 => 'Corp (A)',
	23 => 'Corp (D)',
	6 => 'Fuel Tech 1 (A)', 
	18 => 'Fuel Tech 1 (D)', 
	7 => 'Fuel Tech 2 (A)', 
	19 => 'Fuel Tech 2 (D)', 
	2 => 'Location (A)',
	14 => 'Location (D)',
	10 => 'POS Race (A)',
	22 => 'POS Race (D)',
	9 => 'POS Size (A)',
	21 => 'POS Size (D)',
	5 => 'POS Type (A)',
	17 => 'POS Type (D)',
 	3 => 'Region (A)',
	15 => 'Region (D)',
	1 => 'Status (A)',
	13 => 'Status (D)',
	4 => 'Tower Name (A)', 
	16 => 'Tower Name (D)');

$userinfo['access'] = explode('.',$userinfo['access']);
$eveRender->Assign($userinfo);
$eveRender->Assign('awaystatus', array( 2 => 'No', 1 => 'Yes'));
$eveRender->Assign('themeset', array( 1 => 'FGV - Default', 2 => 'Original POS-Tracker', 3 => 'Majesta Empire', 4 => 'Razor Alliance', 5 => 'Morsus Mihi'));
$eveRender->Assign('user_track_display', array( 10 => '10', 15 => '15', 30 => '30', 50=> '50', 75 => '75', 100 => '100'));
$eveRender->Assign('user_track_sort', $user_track_sort);
$eveRender->Assign('IS_IGB', $IS_IGB);

$eveRender->Display('user.tpl');

?>
