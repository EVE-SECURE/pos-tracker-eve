<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker upgrade script
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

//$userinfo = $posmgmt->GetUserInfo();
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array('5', $access)) {
    $eve->SessionSetVar('errormsg', 'User Not Logged In!');
    $eve->RedirectUrl('login.php');
}

$upgradeList=array(
333=>'FG Update for Tyrannis',
501=>'v5.0.1 - Material Volume Fix',
502=>'v5.0.2 - Theme Install',
511=>'v5.1.1 - Incursion DB & Corp Jobs Install'
);

$eveRender->Assign('upgradeList', $upgradeList);

$step = $eve->VarCleanFromInput('step');

$step = ((empty($step)) ? $step = 1 : $step);

if ($step <= 1) {
    $install = false;
}

$upgrade = $eve->VarCleanFromInput('upgrade');
if($step == 1) {
$eveRender->Assign('step',    $step);
}
if($step == 2) {
	$dbconn =& DBGetConn(true);
	$sql = file_get_contents('install/upgrade/'.$upgrade.'.sql');
    $sql = preg_replace('/%prefix%/', TBL_PREFIX, $sql);
    $sql = trim($sql);
    $sql = explode(';', $sql);
    foreach ($sql as $query) {
        $query = trim($query);
		$dbconn->Execute($query);
        if (empty($query)) { continue; }
        $sqls[] = $query;
    }
    $eveRender->Assign('querycount', 0);
    $eveRender->Assign('querytotal', count($sqls));
	$eveRender->Assign('step',    $step);
}

$eveRender->Display('install/upgrade.tpl');