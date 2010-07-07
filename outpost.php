<?php
/**
 * Pos-Tracker2
 *
 * Outpost tracking page
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
 * @version    SVN: $Id: outpost.php 243 2009-04-26 16:10:33Z stephenmg $
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
//echo '<pre>';print_r($config); echo '</pre>';exit;
$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$access = $eve->SessionGetVar('access');

$eveRender->Assign('access', $access);

if ($access >= '3') {

	$outposts = $posmgmt->GetAllOutpost();

	foreach($outposts as $key => $row) {
		$row['outpostuptime']=$posmgmt->outpostUptimeCalc($row['outpost_id']);
		$update = $posmgmt->GetLastOutpostUpdate($row['outpost_id']);
		$row['lastupdate'] = gmdate("Y-m-d H:i:s", $update['datetime']);
		$row['outpostonline']=$posmgmt->outpost_online($row['outpostuptime']);
		$row['outpostdaycalc']=$posmgmt->daycalc($row['outpostonline']);
		$outposts[$key] = $row;
	}

	$eveRender->Assign('config',    $config);
	$eveRender->Assign('outposts',     $outposts);
		
	$eveRender->Display('outpost.tpl');
} else {

  $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
  $eve->RedirectUrl('track.php');

}

