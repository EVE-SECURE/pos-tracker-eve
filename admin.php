<?php
/**
 * Pos-Tracker2
 *
 * Starbase Tracking Page, multiple Tower view
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

$userinfo = $posmgmt->GetUserInfo();

if (!$userinfo || $userinfo['access'] < 3) {
    $eve->SessionSetVar('errormsg', 'Admin Access Level Required - Please login!');
    $eve->RedirectUrl('login.php');
}
$access = $userinfo['access'];

$eveRender->Assign('access', $access);

$op = $eve->VarCleanFromInput('op');

if ($op == 'modules') {

    $posmgmt->ModuleLoadVars();

    $func = $eve->VarCleanFromInput('func');

    if ($func == 'install' || $func == 'uninstall') {

        $modname = $eve->VarCleanFromInput('modname');

        if (file_exists('mods/'.$modname.'/install.php')) {

            include_once 'mods/'.$modname.'/install.php';
            if(function_exists($modname.'_'.$func)) {
                $install = $modname.'_'.$func;
                $result = $install();
            } else {
                $result = 0;
            }
        } else {
            $result = (($func == 'install') ? 1 : 0);
        }

        $posmgmt->ChangeModState(array('modname' => $modname, 'modstate' => $result));

        $eve->RedirectUrl('admin.php?op=modules');
    } else {

        $modlist = $posmgmt->GetModList();
        //echo '<pre>';print_r($GLOBALS);echo '</pre>';exit;

        $eveRender->Assign('mods', $modlist);

        $eveRender->Display('admin_mods.tpl');
        exit;
    }

}


$action = $eve->VarCleanFromInput('action');

if ($action == 'updatealliance') {
    $results = $posmgmt->API_UpdateAlliances();

    $eveRender->Assign('action',  $action);
    $eveRender->Assign('results', $results);

    $eveRender->Display('admin.tpl');
    exit;
} elseif ($action == 'updatesovereignty') {
    $sovcount = $posmgmt->API_UpdateSovereignty();

    $eveRender->Assign('action',   $action);
    $eveRender->Assign('sovcount', $sovcount);

    $eveRender->Display('admin.tpl');
    exit;

} elseif ($action == 'getcharacters') {
    $apikey = $eve->VarCleanFromInput('apikey');
    $userid = $eve->VarCleanFromInput('userid');

    if (empty($apikey) || empty($userid)) {
        $eve->SessionSetVar('errormsg', 'Missing Information!');
        $eve->RedirectUrl('admin.php');
    }

    $characters = $posmgmt->API_GetCharacters($userid, $apikey);

    if (!$characters) {
        //$eve->SessionSetVar('errormsg', 'ERROR or No Character!');
        $eve->RedirectUrl('admin.php');
    }

    foreach($characters as $key => $char) {

        $apicorp = $posmgmt->API_GetCorpInfo($char['corporationID']);

        $characters[$key]['alliance'] = $apicorp;

        $optchars[$char['characterID']] = $char['name'];
    }

    //echo '<pre>';print_r($characters);echo '</pre>';exit;
    $eveRender->Assign('action',     $action);
    $eveRender->Assign('apikey',     $apikey);
    $eveRender->Assign('userid',     $userid);
    $eveRender->Assign('optchars',   $optchars);
    $eveRender->Assign('characters', $characters);

    $eveRender->Display('admin.tpl');
    exit;

} elseif ($action == 'saveapi') {
    $apikey = $eve->VarCleanFromInput('apikey');
    $userid = $eve->VarCleanFromInput('userid');


    $args['apikey']          = $eve->VarCleanFromInput('apikey');
    $args['userID']          = $eve->VarCleanFromInput('userid');
    $args['characterID']     = $eve->VarCleanFromInput('characterID');
    $args['corporationName'] = $eve->VarCleanFromInput('corporationName');
    $args['corporationID']   = $eve->VarCleanFromInput('corporationID');
    $args['allianceName']    = $eve->VarCleanFromInput('allianceName');
    $args['allianceID']      = $eve->VarCleanFromInput('allianceID');

    $savekey = $posmgmt->API_SaveKey($args);

    if ($savekey) {
        $eve->SessionSetVar('statusmsg', 'API Key Saved!');
    }

    $eve->RedirectUrl('admin.php');

} elseif ($action == 'updatekey') {
    $keyremove = $eve->VarCleanFromInput('keyremove');
//echo '<pre>';print_r($userremove);echo '</pre>';exit;

    foreach ($keyremove as $id => $remove) {
        if (!$posmgmt->DeleteKey($id)) {
            $eve->RedirectUrl('admin.php');
        }
    }
    $eve->SessionSetVar('statusmsg', 'Information Saved!');
    $eve->RedirectUrl('admin.php');

} elseif ($action == 'updatedatafromapi') {

    @set_time_limit(0);
    $results = $posmgmt->API_UPDATEAllPOSES();

    if (!$results) {
        //$eve->SessionSetVar('errormsg', 'ERROR or No Character!');
        $eve->RedirectUrl('admin.php');
    }
//echo '<pre>';print_r($results);echo '</pre>';exit;
    $eveRender->Assign('action',    $action);
    $eveRender->Assign('posupdate', $results['posupdate']);
    $eveRender->Assign('results',   $results);

    $eveRender->Display('admin.tpl');
    exit;
} elseif ($action == 'updateusers') {
    $usertrust  = $eve->VarCleanFromInput('usertrust');
    $useraccess = $eve->VarCleanFromInput('useraccess');
    $userremove = $eve->VarCleanFromInput('userremove');
//echo '<pre>';print_r($userremove);echo '</pre>';exit;

    foreach ($userremove as $id => $remove) {
        if (!$posmgmt->DeleteUser($id)) {
            $eve->RedirectUrl('admin.php');
        }
        unset($useraccess[$id]);
        unset($usertrust[$id]);
    }

    foreach ($useraccess as $id => $uaccess) {
        $uinfo = array('id' => $id, 'access' => $uaccess, 'highly_trusted' => $usertrust[$id]);

        if (!$posmgmt->UpdateUserAccess($uinfo)) {
            $eve->RedirectUrl('admin.php');
        }
    }

    $eve->SessionSetVar('statusmsg', 'Information Saved!');
    $eve->RedirectUrl('admin.php');

} elseif ($action == 'moons') {

  $additional_header[] = '<script type="text/javascript" src="javascript/admin.js"></script>';

  $do = $eve->VarCleanFromInput('do');
  if ($do) {
    echo $do();
    exit;
  }

  $regions = $posmgmt->GetAllRegions();

    $regionID = $eve->VarCleanFromInput('regionID');

/*
    if (!empty($regionID)) {

        $dbconn =& DBGetConn(true);
        switch($regions[$regionID]['installed']) {
            case 0:
                $sql = file_get_contents('install/'.$regions[$regionID]['file_name']);
        $sql = preg_replace('/pos2_/', TBL_PREFIX, $sql);
                $sql = explode(';', $sql);
                foreach ($sql as $query) {
                    $query = trim($query);
                    if (empty($query)) { continue; }
                    $query = str_replace("%prefix%", TBL_PREFIX, $query); // Need a more dynamic way.
                    $dbconn->Execute($query);

                    if ($dbconn->ErrorNo() != 0) {
                        $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
                        $eveRender->RedirectUrl('admin.php?action=moons');
                    }
                }
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '1' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Installed!');
                //$regions[$regionID]['installed'] = 1;
                break;
            case 1:
                $sql = "DELETE FROM ".TBL_PREFIX."evemoons WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '0' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Uninstalled!');
                //$regions[$regionID]['installed'] = 0;
                break;
        }
        $eve->RedirectUrl('admin.php?action=moons');
    }*/

    //$eveRender->Assign('step',    $step);
    $eveRender->Assign('regions', $regions);
    $eveRender->Display('admin_moons.tpl');
    exit;

}
//Begin API KEy Mangager
$keys=$posmgmt->API_GetKeyInfo();
foreach($keys as $index => $key) {
$shortkey     = substr($key['apikey'], 0, 5);
$keys[$index]['shortkey']=$shortkey;
}
$eveRender->Assign('keys',     $keys);
//echo"<pre>";print_r($keys);echo"</pre>";exit;


$users = $posmgmt->GetAllUsers();

for ($x = 0; $x < $access; $x++) {
  switch ($x) {
	case 0:
		$optaccess[] = 'No Access';
	break;
	case 1:
		$optaccess[] = 'View Only';
	break;
	case 2:
		$optaccess[] = 'Fuel Tech';
	break;
	case 3:
		$optaccess[] = 'View-All Manager';
	break;
	case 4:
		$optaccess[] = 'Director';
	break;
	case 5:
		$optaccess[] = 'Admin';
	break;
  }
}
//echo '<pre>';print_r($userinfo);echo '</pre>';exit;
$eveRender->Assign('users',     $users);
$eveRender->Assign('userinfo',  $userinfo);
$eveRender->Assign('optaccess', $optaccess);
$eveRender->Assign('awaylevel',  array(0 => 'Default', 1 => 'Away', 2 => 'Receive eMails'));
$eveRender->Assign('accesslevel',  array(0 => 'No Access', 1 => 'View Only', 2 => 'Fuel Tech', 3 => 'View-All Manager', 4 => 'Director', 5 => 'Admin'));
$eveRender->Assign('opttrust',  array(0 => 'No', 1 => 'Yes'));

$time = time();
$pulltime     = $posmgmt->GetLastSystemUpdate();
$pulltimeally = $posmgmt->GetLastAllianceUpdate();
$pullapitimer = $posmgmt->GetLastAPITimer();
$sovtime      = $posmgmt->get_formatted_timediff($pulltime, $now = false);
$allytime     = $posmgmt->get_formatted_timediff($pulltimeally, $now = false);
$apitime      = $posmgmt->get_formatted_timediff($pullapitimer, $now = false);

$sovtimedifference  = $time - $pulltime;
$allytimedifference = $time - $pulltimeally;
$apitimedifference  = $time - $pullapitimer;

$allyupdate = (($allytimedifference >= INT_DAY) ? true : false);
$systupdate = (($sovtimedifference  >= INT_DAY) ? true : false);
$apiupdate  = (($apitimedifference  >= INT_DAY) ? true : false);

$eveRender->Assign('sovtime',    $sovtime);
$eveRender->Assign('allytime',   $allytime);
$eveRender->Assign('apitime',    $apitime);
$eveRender->Assign('allyupdate', $allyupdate);
$eveRender->Assign('systupdate', $systupdate);
$eveRender->Assign('apiupdate',  $apiupdate);

$eveRender->Display('admin.tpl');

function Ajax_InstallRegion()
{
    global $eve, $posmgmt;

    $regions = $posmgmt->GetAllRegions();

    $regionID = $eve->VarCleanFromInput('regionID');

    $dbconn =& DBGetConn(true);

    if (!empty($regionID)) {
        switch($regions[$regionID]['installed']) {
            case 0:
                $sql = file_get_contents('install/'.$regions[$regionID]['file_name']);
                $sql = explode(';', $sql);
                foreach ($sql as $query) {
                    $query = trim($query);
                    if (empty($query)) { continue; }
                    $query = str_replace("%prefix%", TBL_PREFIX, $query); // Need a more dynamic way.
                    $dbconn->Execute($query);

                    if ($dbconn->ErrorNo() != 0) {
                        $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
                        $eve->RedirectUrl('admin.php?action=moons');
                    }
                }
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '1' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                //$eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Installed!');
                break;
            case 1:
                $sql = "DELETE FROM ".TBL_PREFIX."evemoons WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '0' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                //$eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Uninstalled!');
                break;
        }
    }

    return $regionID;

}

function Ajax_UpgradeTables()
{

    $sql = file_get_contents('install/upgrade21x.sql');
    $sql = preg_replace('/%prefix%/', TBL_PREFIX, $sql);
    $sql = explode(';', $sql);

    $dbconn =& DBGetConn(true);

    foreach ($sql as $query) {
        $query = trim($query);
        if (empty($query)) { continue; }
        $dbconn->Execute($query);

        if ($dbconn->ErrorNo() != 0) {
            $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
            $eveRender->Display('install/install.tpl');
            exit;
        }
    }

    return 'done';

}

function Ajax_WriteTables()
{

    $sql = file_get_contents('install/install_database.sql');
    $sql = preg_replace('/%prefix%/', TBL_PREFIX, $sql);
    $sql = explode(';', $sql);

    $dbconn =& DBGetConn(true);

    foreach ($sql as $query) {
        $query = trim($query);
        if (empty($query)) { continue; }
        $dbconn->Execute($query);

        if ($dbconn->ErrorNo() != 0) {
            $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
            $eveRender->Display('install/install.tpl');
            exit;
        }
    }

    return 'done';

}

function Ajax_WriteConfig()
{
    global $eve;

    $args['dbhost']   = $eve->VarCleanFromInput('dbhost');
    $args['dbuname']  = $eve->VarCleanFromInput('dbuname');
    $args['dbpass']   = $eve->VarCleanFromInput('dbpass');
    $args['dbname']   = $eve->VarCleanFromInput('dbname');
    $args['dbprefix'] = $eve->VarCleanFromInput('dbprefix');

    return update_dbconfig_php($args);

}

function Ajax_CheckDB()
{

    global $eve, $eveRender, $stoppage;

    $host = $eve->VarCleanFromInput('dbhost');
    $user = $eve->VarCleanFromInput('dbuname');
    $pass = $eve->VarCleanFromInput('dbpass');
    $db   = $eve->VarCleanFromInput('dbname');

    if (empty($host)) {
        $host = 'localhost';
    }

    $dbok    = false;
    $server  = false;
    $goforit = false;

    include_once 'includes/dbfunctions.php';

    $GLOBALS['dbconfig']['dbtype']   = 'mysql';
    $GLOBALS['dbconfig']['dbhost']   = $host;
    $GLOBALS['dbconfig']['dbname']   = $db;
    $GLOBALS['dbconfig']['dbuname']  = $user;
    $GLOBALS['dbconfig']['dbpass']   = $pass;
    $GLOBALS['dbconfig']['pconnect'] = 0;
    $GLOBALS['dbconfig']['encoded']  = 0;
    $GLOBALS['dbconfig']['debug']    = 0;
    $GLOBALS['dbdebug']['debug_sql'] = 0;

    $answer = '';

    if (empty($user)) {
        return 'No database username';
    }


    if (!DBInit()) {
        $mysqlerror = 'Database Failure!';//$dbconn->ErrorMsg();
        $server = false;
        $selectdb = false;
        $stoppage = true;
    } else {
        $server = true;
        if (!$dbconn =& DBGetConn(true)) {
            $answer .= 'Connection Failed!';
            $stoppage = true;
        } else {
            $selectdb = $dbconn->SelectDB($db);
            if (!$selectdb) {
                $mysqlerror = 'Unknown Database';
                $stoppage = true;
            }
            if (!$stoppage) {
                $result = $dbconn->Execute('SELECT VERSION() AS version');
                if ($dbconn->ErrorNo()!=0) {
                    $selectdb = true;
                    $mysqlerror = $dbconn->ErrorMsg();
                    $stoppage = true;
                } else {
                    list($version) = $result->fields;
                }
            }
        }
        if (!$stoppage) { $goforit = true; }
    }

    if ($goforit) {
        $answer .= 'DATABASE OK - Version: ' . $version . ' - Hit the Write button to save the configuration.';
    }else{
        $answer .= $mysqlerror;
    }

    return $answer;

}

function add_src_rep($key, $rep)
{
    global $reg_src, $reg_rep;
    // Note: /x is to permit spaces in regular expressions
    // Great for making the reg expressions easier to read
    // Ex: $pnconfig['sitename'] = stripslashes("Your Site Name");
    $reg_src[] = "/ \['$key'\] \s* = \s* stripslashes\( (\' | \") (.*) \\1 \); /x";
    $reg_rep[] = "['$key'] = stripslashes(\\1$rep\\1);";
    // Ex. $pnconfig['site_logo'] = "logo.gif";
    $reg_src[] = "/ \['$key'\] \s* = \s* (\' | \") (.*) \\1 ; /x";
    $reg_rep[] = "['$key'] = '$rep';";
    // Ex. $pnconfig['pollcomm'] = 1;
    $reg_src[] = "/ \['$key'\] \s* = \s* (\d*\.?\d*) ; /x";
    $reg_rep[] = "['$key'] = $rep;";
}

function update_dbconfig_php($args = array())
{

    global $reg_src, $reg_rep;

    if (!$args) {
        return false;
    }

    $dbhost      = $args['dbhost'];
    $dbuname     = $args['dbuname'];
    $dbpass      = $args['dbpass'];
    $dbname      = $args['dbname'];
    $dbtype      = $args['dbtype'];
    $prefix      = $args['dbprefix'];
    $dbtabletype = $args['dbtabletype'];
    $encoded     = 1;

    add_src_rep("dbhost",      $dbhost);
    add_src_rep("dbuname",     base64_encode($dbuname));
    add_src_rep("dbpass",      base64_encode($dbpass));
    add_src_rep("dbname",      $dbname);
    add_src_rep("prefix",      $prefix);
    //add_src_rep("dbtype",      $dbtype);
    //add_src_rep("dbtabletype", $dbtabletype);
    add_src_rep("encoded",     '1');
    add_src_rep("pconnect",    '0');

    //$ret = modify_file('eveconfig/dbconfig.php', 'eveconfig/dbconfig-old.php', $reg_src, $reg_rep);
    $ret = modify_file('eveconfig/dbconfig.php', '', $reg_src, $reg_rep);

    if (preg_match("/Error/", $ret)) {
        show_error_info();
    }

    return $ret;
}

// mod_file is general, give it a source file a destination.
// an array of search patterns (Perl style) and replacement patterns
// Returns a string which starts with "Err" if there's an error
function modify_file($src, $dest, $reg_src, $reg_rep)
{
    $in = @fopen($src, "r");
    if (! $in) {
        return _MODIFY_FILE_1 . " $src";
    }
    $i = 0;
    while (!feof($in)) {
        $file_buff1[$i++] = fgets($in, 4096);
    }
    fclose($in);

    $lines = 0; // Keep track of the number of lines changed

    while (list ($bline_num, $buffer) = each ($file_buff1)) {
        $new = preg_replace($reg_src, $reg_rep, $buffer);
        if ($new != $buffer) {
            $lines++;
        }
        $file_buff2[$bline_num] = $new;
    }

    if ($lines == 0) {
        // Skip the rest - no lines changed
        return "0 lines changed, did nothing";
    }

    if (!empty($dest)) {
        reset($file_buff1);
        $out_backup = @fopen($dest, "w");

        if (! $out_backup) {
            return "Error: unable to open for write: $dest";
        } while (list ($bline_num, $buffer) = each ($file_buff1)) {
            fputs($out_backup, $buffer);
        }

        fclose($out_backup);
    }

    reset($file_buff2);
    $out_original = fopen($src, "w");
    if (! $out_original) {
        return "Error: unable to open for write: $src";
    } while (list ($bline_num, $buffer) = each ($file_buff2)) {
        fputs($out_original, $buffer);
    }

    fclose($out_original);
    // Success!
    return "$src updated with $lines lines of changes".((!empty($dest)) ? ", backup is called $dest" : "");
}
?>
