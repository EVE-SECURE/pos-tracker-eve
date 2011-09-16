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
include_once 'includes/api.php';
include_once 'includes/eveRender.class.php';
include_once 'version.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config', $config);
$eveRender->Assign('version', VERSION);

$eve = New Eve();
$posmgmt = New POSMGMT();
$API = New API();

$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

if (!$userinfo || ($userinfo['access'] != 5 && $userinfo['access'] != 6)) {
		$eve->SessionSetVar('errormsg', 'Admin Access Level Required - Please login!');
		$eve->RedirectUrl('login.php');
	} else {
	$access = explode('.',$userinfo['access']);
	$eveRender->Assign('access', $access);
}

$file_check = 'install.php';
$installchecker = ((file_exists($file_check)) ? true : false);
$eveRender->Assign('installchecker',    $installchecker);

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

        $eveRender->Assign('mods', $modlist);

        $eveRender->Display('admin_mods.tpl');
        exit;
    }

}


$action = $eve->VarCleanFromInput('action');
$settings = $posmgmt->GetSettings();

if ($settings[2]['gsetting'] == 1) {
	$vcheck = isUpToDate();
	$eveRender->Assign('vcheck', $vcheck);
}

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
} elseif ($action == 'updatejobs') {
    $results = $posmgmt->API_UpdateIndustryJobs();

    $eveRender->Assign('action',   $action);
    $eveRender->Assign('results', $results);

    $eveRender->Display('admin.tpl');
    exit;

} elseif ($action == 'updatepricesapi') {

	$args = $settings[1]['gsetting'];
    $results = $API->API_UpdatePrices($args);

    $eveRender->Assign('action',   $action);
    $eveRender->Assign('results', $results);

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
    $eveRender->Assign('action',    $action);
    $eveRender->Assign('posupdate', $results['posupdate']);
    $eveRender->Assign('results',   $results);

    $eveRender->Display('admin.tpl');
    exit;
	
} elseif ($action == 'updateprices') {
	$PricesUpdate = $eve->VarCleanFromInput('PricesUpdate');

	foreach ($PricesUpdate as $id => $value) {
	$pinfo = array('name' => $id, 'value' => $value);
        if (!$posmgmt->UpdatePrices($pinfo)) {
            $eve->RedirectUrl('admin.php');
        }
	 }
	 $eve->SessionSetVar('statusmsg', 'Prices updated manually!');
} elseif ($action == 'updatesettings') {
	$SettingsUpdate = $eve->VarCleanFromInput('SettingsUpdate');

	foreach ($SettingsUpdate as $id => $value) {
	$sinfo = array('name' => $id, 'value' => $value);
        if (!$posmgmt->UpdateSettings($sinfo)) {
            $eve->RedirectUrl('admin.php');
        }
	 }
	 $settings = $posmgmt->GetSettings();
	 $eve->SessionSetVar('statusmsg', 'Global Settings Updated!');
} elseif ($action == 'updateusers') {
    $userremove = $eve->VarCleanFromInput('userremove');
	$UserList = $eve->VarCleanFromInput('UserList');
	$UserEnabled = $eve->VarCleanFromInput('UserEnabled');
	$CorpAccess = $eve->VarCleanFromInput('CorpAccess');
	$OtherCorpAccess = $eve->VarCleanFromInput('OtherCorpAccess');
	$OutpostAccess = $eve->VarCleanFromInput('OutpostAccess');
	$JobAccess = $eve->VarCleanFromInput('JobAccess');
	$ProdAccess = $eve->VarCleanFromInput('ProdAccess');
	$TrustAccess = $eve->VarCleanFromInput('TrustAccess');
	$SubAdminAccess = $eve->VarCleanFromInput('SubAdminAccess');

    foreach ($userremove as $id => $remove) {
        if (!$posmgmt->DeleteUser($id)) {
            $eve->RedirectUrl('admin.php');
        }
        unset($useraccess[$id]);
        unset($usertrust[$id]);
    }

    foreach ($UserList as $id => $uaccess) {
		
		if ($SubAdminAccess[$id] != 6) {
		$AccessArray = array($UserEnabled[$id], $CorpAccess[$id], $OtherCorpAccess[$id], $OutpostAccess[$id], $JobAccess[$id], $ProdAccess[$id], $TrustAccess[$id], $SubAdminAccess[$id]);
		$uaccess = implode(".",array_filter($AccessArray));
		} elseif ($SubAdminAccess[$id] == 6) {
		$uaccess = 6;
		}
			
        $uinfo = array('id' => $id, 'access' => $uaccess);

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

    $eveRender->Assign('regions', $regions);
    $eveRender->Display('admin_moons.tpl');
    exit;

} elseif ($action == 'versioncheck') {

$vcheck = isUpToDate();
$eveRender->Assign('vcheck', $vcheck);

}

//Begin API KEy Mangager
$keys=$posmgmt->API_GetKeyInfo();
foreach($keys as $index => $key) {
$shortkey     = substr($key['apikey'], 0, 5);
$keys[$index]['shortkey']=$shortkey;
}
$eveRender->Assign('keys',     $keys);

$users = $posmgmt->GetAllUsers();
$prices = $posmgmt->GetPrices();

$eveRender->Assign('users',     $users);
$eveRender->Assign('prices',     $prices);
$eveRender->Assign('settings',     $settings);
$eveRender->Assign('userinfo',  $userinfo);
$eveRender->Assign('awaylevel',  array(0 => 'Default', 1 => 'Away', 2 => 'Receive eMails'));

$time = time();
$pulltime     = $posmgmt->GetLastSystemUpdate();
$pulltimeally = $posmgmt->GetLastAllianceUpdate();
$pulljobtime = $posmgmt->GetLastJobUpdate(5);
$pullapitimer = $posmgmt->GetLastAPITimer();
$sovtime      = $posmgmt->get_formatted_timediff($pulltime, $now = false);
$allytime     = $posmgmt->get_formatted_timediff($pulltimeally, $now = false);
$jobtime     = $posmgmt->get_formatted_timediff($pulljobtime, $now = false);
$apitime      = $posmgmt->get_formatted_timediff($pullapitimer, $now = false);

$sovtimedifference  = $time - $pulltime;
$allytimedifference = $time - $pulltimeally;
$jobtimedifference = $time - $pulljobtime;
$apitimedifference  = $time - $pullapitimer;

$allyupdate = (($allytimedifference >= INT_DAY) ? true : false);
$systupdate = (($sovtimedifference  >= INT_DAY) ? true : false);
$jobupdate = (($jobtimedifference  >= INT_DAY) ? true : false);
$apiupdate  = (($apitimedifference  >= INT_DAY) ? true : false);

$eveRender->Assign('sovtime',    $sovtime);
$eveRender->Assign('allytime',   $allytime);
$eveRender->Assign('jobtime',    $jobtime);
$eveRender->Assign('apitime',    $apitime);
$eveRender->Assign('allyupdate', $allyupdate);
$eveRender->Assign('systupdate', $systupdate);
$eveRender->Assign('jobupdate', $jobupdate);
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

function isUpToDate()
{
    $latestVersion=trim(file_get_contents(REMOTE_VERSION));
	if (version_compare(VERSION, $latestVersion, 'eq') == 1) {
	return "Your installation is up to date!";
	}
	else {
	return "$latestVersion - <font color='red'>Your installation is not up to date!</font><BR>Get the latest version here: <a href='http://www.iceneko.com/eve/' target='_blank'>Click Me!</a>";
	}
	
}
?>
