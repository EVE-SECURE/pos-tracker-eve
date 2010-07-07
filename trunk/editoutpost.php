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
 * @version    SVN: $Id: editoutpost.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();


$access = $eve->SessionGetVar('access');

if ($access < 2) {
    $eve->RedirectUrl('login.php');
}

$eveRender->Assign('access', $access);

$outpost_id = $eve->VarCleanFromInput('i');
// Dirty fix
if (empty($outpost_id)) {
    $outpost_id = $eve->VarCleanFromInput('outpost_id');
}
if (empty($outpost_id)) {
    $eve->SessionSetVar('errormsg', 'No Outpost ID!');
    $eve->RedirectUrl('track.php');
}
if (!is_numeric($outpost_id)) {
    $eve->SessionSetVar('errormsg', 'Incorrect Outpost ID!');
    $eve->RedirectUrl('track.php');
}

$action = $eve->VarCleanFromInput('action');
switch($action) {
    case 'Update Outpost Hangar':

		$fuel['uranium']         = $eve->VarCleanFromInput('uranium');
		$fuel['oxygen']          = $eve->VarCleanFromInput('oxygen');
		$fuel['mechanical_parts']= $eve->VarCleanFromInput('mechanical_parts');
		$fuel['coolant']         = $eve->VarCleanFromInput('coolant');
		$fuel['robotics']        = $eve->VarCleanFromInput('robotics');
		$fuel['heisotope']       = $eve->VarCleanFromInput('heisotope');
		$fuel['hyisotope']       = $eve->VarCleanFromInput('hyisotope');
		$fuel['oxisotope']       = $eve->VarCleanFromInput('oxisotope');
		$fuel['niisotope']       = $eve->VarCleanFromInput('niisotope');
		$fuel['ozone']           = $eve->VarCleanFromInput('ozone');
		$fuel['heavy_water']     = $eve->VarCleanFromInput('heavy_water');
		$fuel['strontium']       = $eve->VarCleanFromInput('strontium');
		$fuel['charters']        = $eve->VarCleanFromInput('charters');
		$fuel['outpost_id']      = $outpost_id;
        if ($posmgmt->UpdateOutpostFuel($fuel)) {
            $eve->SessionSetVar('statusmsg', 'Modifications Saved!');
            $eve->RedirectUrl('viewoutpost.php?i='.$outpost_id);
        }
        break;
}

//Gather Outpost Data
$outpost = $posmgmt->GetOutpostInfo($outpost_id);
$hoursago = $posmgmt->hoursago($outpost_id, '4');
$update = $posmgmt->GetLastOutpostUpdate($outpost_id);
$outpost['hoursago']=$hoursago;
$outpost['lastupdate'] = gmdate("Y-m-d H:i:s", $update['datetime']);

//Assign Outpost Data to template
$eveRender->Assign('outpost',   $outpost);

//Display template
$eveRender->Display('editoutpost.tpl');

?>