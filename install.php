<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker install page
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
include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//error_reporting(E_ALL);

$eveRender = New eveRender($config, '', false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$step = $eve->VarCleanFromInput('step');
$action = $eve->VarCleanFromInput('action');
if($action && !isset($step))
{
	$step=5;
}
$step = ((empty($step)) ? $step = 1 : $step);


if ($step <= 1) {
    $install = false;
}
if ($step > 1) {
    include_once 'includes/dbfunctions.php';
    EveDBInit();

    $dbconn =& DBGetConn(true);

    $sql = "SELECT * FROM ".$dbconfig['prefix']."user";
    $result = $dbconn->Execute($sql);
    if ($dbconn->ErrorNo() != 0) {
        $install = false;
    } else {
        $install = true;
    }
}

if ($step == 1) {

    $do = $eve->VarCleanFromInput('do');

    if ($do) {
        echo $do();
        exit;
    }
    
    if (!isset($dbconfig)) { $dbconfig = null;}

    $eveRender->Assign('dbhost',     $dbconfig['dbhost']);
    $eveRender->Assign('dbuname',    $dbconfig['dbuname']);
    $eveRender->Assign('dbname',     $dbconfig['dbname']);
    $eveRender->Assign('dbprefix',   $dbconfig['prefix']);
    $eveRender->Assign('phpversion', phpversion());

    $extensions = get_loaded_extensions();
    $functions  = get_defined_functions();
    $hash      = ((in_array('hash',      $extensions)) ? 'Yes' : 'No');
    $simpleXML = ((in_array('SimpleXML', $extensions)) ? 'Yes' : 'No');
    $curl      = ((in_array('curl',      $extensions)) ? 'Yes' : 'No');
    $fopen     = ((in_array('fopen',     $functions['internal']))  ? 'Yes' : 'No');
    $regGlobals= ini_get('register_globals');
    if(empty($regGlobals) || $regGlobals=='0') {
        $regester_globals='Off';    
    } else {
        $register_globals='On - Please turn register_globals off';    
    }

    $eveRender->Assign('hash',        $hash);
    $eveRender->Assign('simpleXML',   $simpleXML);
    $eveRender->Assign('curl',        $curl);
    $eveRender->Assign('curlversion', (($curl=='Yes') ? curl_version() : '0'));
    $eveRender->Assign('fopen',       $fopen);
    $eveRender->assign('register_globals', $regester_globals);
    $eveRender->Assign('cache',       is_writable('cache/templates_c'));
    $eveRender->Assign('dbconfig',    is_writable('eveconfig/dbconfig.php'));
    $eveRender->Assign('step', $step);

    $sql = file_get_contents('install/install_database.sql');
    $sql = preg_replace('/%prefix%/', $dbconfig['prefix'], $sql);
    $sql = explode(';', $sql);
    foreach ($sql as $query) {
        $query = trim($query);
        if (empty($query)) { continue; }
        $sqls[] = $query;
    }
    $eveRender->Assign('querycount', 0);
    $eveRender->Assign('querytotal', count($sqls));
    $eveRender->Display('install/install.tpl');

} elseif ($step == 2) {

    $eveRender->Assign('step', $step);

    $do = $eve->VarCleanFromInput('do');
    if ($do) {
        echo $do();
        exit;
    }

    $upgrade = $eve->VarCleanFromInput('upgrade');
    if ($upgrade) {
        //$eveRender->Assign('upgrade', $upgrade);
        $eve->SessionSetVar('statusmsg', 'Tables created/updated succesfully');
        $eve->RedirectUrl('install.php?step=4');
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

    $eveRender->Assign('done', true);
    $eveRender->Display('install/install.tpl');
    exit;

} elseif ($step == 3) {

    $name  = $eve->VarCleanFromInput('name');
    $pass  = $eve->VarCleanFromInput('pass');
    $email = $eve->VarCleanFromInput('email');

    if (empty($pass) || empty($email)) {
        $eve->SessionSetVar('errormsg', 'Please fill all the fields of the form!');
        $eve->RedirectUrl('install.php?step=2');
    }

    $time   = time();
    $dbhash = $posmgmt->newpasswordhash($pass);

    $sql = "INSERT INTO ".TBL_PREFIX."user
            SET         eve_id    = '1',
                        name      = '" . $eve->VarPrepForStore('Admin')."',
                        pass      = '" . $eve->VarPrepForStore($dbhash) . "',
                        email     = '" . $eve->VarPrepForStore($email) . "',
                        access    = '5',
                        datetime  = '" . $eve->VarPrepForStore($time) . "'";
    $dbconn->Execute($sql);

    if ($dbconn->ErrorNo() != 0) {
        $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
        $eve->RedirectUrl('install.php?step=2');
    }
    $eve->SessionSetVar('statusmsg', 'Admin Registered');

    $eve->RedirectUrl('install.php?step=4');

} elseif ($step == 4) {

    $regions = $posmgmt->GetAllRegions();

    $regionID = $eve->VarCleanFromInput('regionID');

    $do = $eve->VarCleanFromInput('do');
    if ($do) {
        echo $do();
        exit;
    }

    if (!empty($regionID)) {
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
                        $eve->RedirectUrl('install.php?step=4');
                    }
                }
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '1' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Installed!');
                break;
            case 1:
                $sql = "DELETE FROM ".TBL_PREFIX."evemoons WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $sql = "UPDATE ".TBL_PREFIX."moonsinstalled SET installed = '0' WHERE regionID = '".$eve->VarPrepForStore($regionID)."'";
                $dbconn->Execute($sql);
                $eve->SessionSetVar('statusmsg', $regions[$regionID]['regionName'].' Uninstalled!');
                break;
        }
        $eve->RedirectUrl('install.php?step=4');
    }

    $eveRender->Assign('step',    $step);
    $eveRender->Assign('regions', $regions);
    $eveRender->Display('install/install.tpl');

} elseif ($step == 5) {
    if ($action == 'getcharacters') {
        $apikey = $eve->VarCleanFromInput('apikey');
        $userid = $eve->VarCleanFromInput('userid');
    	

        if (empty($apikey) || empty($userid)) {
            $eve->SessionSetVar('errormsg', 'Missing Information!');
            $eve->RedirectUrl('install.php?step=5');
        }

        $characters = $posmgmt->API_GetCharacters($userid, $apikey);

        if (!$characters) {
            //$eve->SessionSetVar('errormsg', 'ERROR or No Character!');
            $eve->RedirectUrl('install.php?step=5');
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

        $eveRender->Display('install/install.tpl');
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

        $eve->RedirectUrl('install.php?step=5');

    } elseif(!$action)
    {
        //Begin API KEy Mangager
        $keys=$posmgmt->API_GetKeyInfo();
        foreach($keys as $index => $key) {
        $shortkey     = substr($key['apikey'], 0, 5);
        $keys[$index]['shortkey']=$shortkey;
        }
        $eveRender->Assign('keys',     $keys);
    	$eveRender->Assign('step',    $step);
    	$eveRender->Display('install/install.tpl');
    	exit;
	}
} elseif ($step == 6) {

    $eve->SessionSetVar('statusmsg', 'Installation/Upgrade done. Please delete the install.php file.');
    $eve->RedirectUrl('index.php');

} 



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
                $sql = preg_replace('/pos2_/', TBL_PREFIX, $sql);
                $sql = explode(';', $sql);
                foreach ($sql as $query) {
                    $query = trim($query);
                    if (empty($query)) { continue; }
                    $query = str_replace("%prefix%", TBL_PREFIX, $query); // Need a more dynamic way.
                    $dbconn->Execute($query);

                    if ($dbconn->ErrorNo() != 0) {
                        $eve->SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $query);
                        $eve->RedirectUrl('install.php?step=4');
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
    //$dbtype      = $args['dbtype'];
    $prefix      = $args['dbprefix'];
    //$dbtabletype = $args['dbtabletype'];
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