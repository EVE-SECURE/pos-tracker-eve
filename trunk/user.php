<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker user control pannel
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
 * @version    SVN: $Id: user.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config', $config);
//echo '<pre>';print_r($config);echo '</pre>';exit;
$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eveinfo  = $eve->GetUserVars();
$userinfo = array_merge($userinfo, $eveinfo);
//echo '<pre>';print_r($userinfo);echo '</pre>';exit;
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
    $away     = $eve->VarCleanFromInput('away');
    $email    = $eve->VarCleanFromInput('email');
    $newpass  = $eve->VarCleanFromInput('newpass');
    $newpass2 = $eve->VarCleanFromInput('newpass2');

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
$eveRender->Assign('IS_IGB', $IS_IGB);

$eveRender->Display('user.tpl');

?>
