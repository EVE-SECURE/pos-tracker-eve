<?php
/**
 * Pos-Tracker2
 *
 * Pos-Tracker register page
 *
 * PHP version 5
 *
 * LICENSE: This file is part of POS-Tracker2.
 * POS-Tracker2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * POS-Tracker2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with POS-Tracker2.  If not, see <http://www.gnu.org/licenses/>.
 *

 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @author      Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2007-2009 (C)  Stephen Gulick, DeTox MinRohim, and Andy Snowden
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    POS-Tracker2
 * @version    SVN: $Id$
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */
if (isset($_REQUEST['viewSource'])) {
  highlight_file(__FILE__);
  exit();
};
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';

include_once 'includes/eveRender.class.php';
include_once 'eveconfig/config.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;

$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();


$userinfo = $eve->GetUserVars();

$action = $eve->VarCleanFromInput('action');
$api_userid = $eve->VarCleanFromInput('api_userid');
$api_key = $eve->VarCleanFromInput('api_key');

if ($action == 'getchars') {
	if (empty($api_key) || empty($api_userid)) {
		$eve->SessionSetVar('errormsg', 'Missing API Information!');
		$eve->RedirectUrl('register.php');
	}

	$characters = $posmgmt->API_GetCharacters($api_userid, $api_key);

	if (!$characters) {
		$eve->SessionSetVar('errormsg', 'API ERROR or No Character on provided API Information!');
		$eve->RedirectUrl('register.php');
	}

	foreach($characters as $key => $char) {
		$apicorp = $posmgmt->API_GetCorpInfo($char['corporationID']);
		$characters[$key]['alliance'] = $apicorp;
	}

	//echo '<pre>';print_r($characters);echo '</pre>';exit;
	$eveRender->Assign('action',     $action);
	$eveRender->Assign('api_userid', $api_userid);
	$eveRender->Assign('api_key',    $api_key);
	$eveRender->Assign('characters', $characters);

	$eveRender->Display('register.tpl');
	exit;
} else if ($action == 'getuserinfo') {
	$charname		= $eve->VarCleanFromInput('charname');
	$characterID		= $eve->VarCleanFromInput('characterID');
	$corporationName	= $eve->VarCleanFromInput('corporationName');
	$corporationID		= $eve->VarCleanFromInput('corporationID');
	$allianceName		= $eve->VarCleanFromInput('allianceName');
	$allianceID		= $eve->VarCleanFromInput('allianceID');


	$eveRender->Assign('action',		$action);
	$eveRender->Assign('api_userid',	$api_userid);
	$eveRender->Assign('api_key',		$api_key);
        $eveRender->Assign('charname',		$charname);
	$eveRender->Assign('characterID',	$characterID);
	$eveRender->Assign('corporationName',	$corporationName);
	$eveRender->Assign('corporationID',	$corporationID);
	$eveRender->Assign('allianceName',	$allianceName);
	$eveRender->Assign('allianceID',	$allianceID);

	$eveRender->Display('register.tpl');
	exit;
} else if ($action == 'saveaccount') {
	$charname		= $eve->VarCleanFromInput('charname');
	$characterID		= $eve->VarCleanFromInput('characterID');
	$corporationName	= $eve->VarCleanFromInput('corporationName');
	$corporationID		= $eve->VarCleanFromInput('corporationID');
	$allianceName		= $eve->VarCleanFromInput('allianceName');
	$allianceID		= $eve->VarCleanFromInput('allianceID');
	$email			= $eve->VarCleanFromInput('email');
	$pass			= $eve->VarCleanFromInput('pass');
	$pass2			= $eve->VarCleanFromInput('pass2');

	$eveRender->Assign('api_userid',	$api_userid);
	$eveRender->Assign('api_key',		$api_key);
        $eveRender->Assign('charname',		$charname);
	$eveRender->Assign('characterID',	$characterID);
	$eveRender->Assign('corporationName',	$corporationName);
	$eveRender->Assign('corporationID',	$corporationID);
	$eveRender->Assign('allianceName',	$allianceName);
	$eveRender->Assign('allianceID',	$allianceID);
	$eveRender->Assign('email',		$email);

	if (empty($pass) || empty($pass2) || empty($email)) {
		$eve->SessionSetVar('errormsg', 'Fill all the fields smartass!');
		$eveRender->Assign('action', 'getuserinfo');
		$eveRender->Display('register.tpl');
		exit;
	}

	if ($pass != $pass2) {
		$eve-SessionSetVar('errormsg', 'Password missmatch, you need to redo it!');
		$eveRender->Assign('action', 'getuserinfo');
		$eveRender->Display('register.tpl');
		exit;
	}

	if ( $allianceID = 0 || empty($allianceName) ) {
		unset($allianceID);
		unset($allianceName);
	};

	$time = time();
	//Password Hash
	$password = $posmgmt->newpasswordhash($pass); //New Password hashing method

	// Is a User with the same characterID already registered?
	$sql = "SELECT * FROM ".TBL_PREFIX."user WHERE eve_id = ".$characterID;
	$result = mysql_query($sql) or die('Could not look for already existing User;' . mysql_error());
	if (mysql_num_rows($result) != 0) {
		// Update Userinfo
		$sql = "UPDATE ".TBL_PREFIX."user
			SET name = '" . $eve->VarPrepForStore($charname) . "',
			    pass = '" . $eve->VarPrepForStore($password) . "',
			    corp = '" . $eve->VarPrepForStore($corporationName) . "',
			    email= '" . $eve->VarPrepForStore($email) . "',
			    alliance_id = '" . $eve->VarPrepForStore($allianceID) . "',
			    datetime = '" . $time . "'
			WHERE eve_id = ".$characterID;
		$result = mysql_query($sql) or die('Could not update user;' . mysql_error());
		$eve->SessionSetVar('errormsg', 'You are already registered you muppet, updating Userinfo for '.$charname.'!');
		$eve->RedirectUrl('login.php');
	}

	// Create new User.
	$sql = "INSERT INTO ".TBL_PREFIX."user (`eve_id`, `name`, `pass`, `corp`, `alliance_id`, `email`, `access`, `datetime`)
		VALUES (
			'" . $eve->VarPrepForStore($characterID) . "',
			'" . $eve->VarPrepForStore($charname) . "',
			'" . $eve->VarPrepForStore($password) . "',
			'" . $eve->VarPrepForStore($corporationName) . "',
			'" . $eve->VarPrepForStore($allianceID) . "',
			'" . $eve->VarPrepForStore($email) . "',
			0,
			'" . $time . "')";
	$result = mysql_query($sql) or die('Could not create user;' . mysql_error());
	$eve->SessionSetVar('statusmsg', 'User Created - Welcome '.$charname);
	$eve->RedirectUrl('login.php');
}


$eveRender->Display('register.tpl');
?>
