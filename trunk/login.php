<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker login page
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
 * @version    SVN: $Id: login.php 243 2009-04-26 16:10:33Z stephenmg $
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

$eve     = New Eve();
$posmgmt = New POSMGMT();

$access = $eve->SessionGetVar('access');
$action = $eve->VarCleanFromInput('action');

$eveRender->Assign('access', $access);

if ($action == 'Login') {

    $name = $eve->VarCleanFromInput('name');
    $pass = $eve->VarCleanFromInput('pass');

    if (empty($name) || empty($pass)) {
        $eve->SessionSetVar('errormsg', 'Please fill the form properly!');
        $eve->RedirectUrl('login.php');
    }

    $user = $posmgmt->LogUser(array('name' => $name, 'pass' => $pass));

    if ($user) {
        $eve->SessionSetVar('statusmsg', 'Welcome '.$user['name']);
        $eve->RedirectURL('track.php');
    } else {
        $eve->SessionSetVar('statusmsg', 'Wrong Login or Pass!');
        $eve->RedirectURL('login.php');
    }
}

if ($eve->IsMiniBrowser()) {
    if (!$eve->IsTrusted()) {
        $eve->RequestTrust('You must add this site to your trusted list to log in in-game!');
    } else {

        $userinfo = $eve->GetUserVars();

        $eveRender->Assign('IS_IGB',   true);
        $eveRender->Assign('userinfo', $userinfo);

    }
} else {
    $eveRender->Assign('IS_IGB', false);
}

$eveRender->Display('login.tpl');







/*
ob_start();
require_once 'config.php';
require_once 'header.php';

echo '<form method="post" action="user-transaction.php">';

if (($_SERVER['HTTP_USER_AGENT'] == "EVE-minibrowser/3.0") && ($_SERVER['HTTP_EVE_TRUSTED'] == "yes")) {
  echo "Welcome ".stripslashes($_SERVER['HTTP_EVE_CHARNAME']).", please enter your password and <b>click</b> on the login-button.<br /><br />";
  echo '<input type="hidden" name="name" value="'.stripslashes($_SERVER['HTTP_EVE_CHARNAME']).'">';
} else {
  echo 'If you are using the in-game browser, you must <b>click</b> the "Login" button!<p>';
  echo 'Character Name: <input type="text" name="name" maxlength="255">';
  echo '<br>';
}
?>
Password:
<input type="password" name="pass" maxlength="255">
<br>
<input type="submit" name="action" value="Login">
</form>

<?php
require_once 'footer.php';
ob_end_flush();*/
?>
