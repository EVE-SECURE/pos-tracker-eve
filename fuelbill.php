<?php
/**
 * Pos-Tracker2
 *
 * Starbase Fuel bill page
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
include_once 'includes/pos_val.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo', $userinfo);

$access = $eve->SessionGetVar('access');
$highly_trusted = $eve->SessionGetVar('highly_trusted');
$eveRender->Assign('access', $access);
if ($access >= '2') {


    /* -- Data settings and controls -- */
    //usecargo =0 use optimal=1

    //$use_current_levels = "0";
    $use_optimals       = "1";
    $use_cargo          = "0";

    /* -- Fuel calculation -- */



    // Clear total values

    $fuel_uranium           = 0;
    $fuel_oxygen            = 0;
    $fuel_mechanical_parts  = 0;
    $fuel_coolant           = 0;
    $fuel_robotics          = 0;
    $fuel_isotopes          = 0;
    $fuel_H_isotopes        = 0;
    $fuel_N_isotopes        = 0;
    $fuel_O_isotopes        = 0;
    $fuel_Hy_isotopes       = 0;
    $fuel_ozone             = 0;
    $fuel_heavy_water       = 0;
    $default_days           = 30;

    $args = array();
    $filter             = $eve->VarCleanFromInput('filter');
    $submit             = $eve->VarCleanFromInput('submit');
    $use_current_levels = $eve->VarCleanFromInput('use_current_levels');//echo $use_current_levels;exit;
    //if (empty($use_current_levels)) { $use_current_levels = 1; }

    if (!empty($filter) || !empty($submit)) {

        $days_to_refuel = $eve->VarCleanFromInput('days_to_refuel');

        if (is_numeric($days_to_refuel)) {
            $args['days_to_refuel'] = $days_to_refuel;
        } else {
            $default_days = 30;
        }

        $pos_ids = $eve->VarCleanFromInput('pos_ids');
        if (is_array($pos_ids)) {
            $optposids = $pos_ids;
            $pos_ids = array_keys($pos_ids);
            $args['pos_ids'] = $pos_ids;
        }

        $systemID = $eve->VarCleanFromInput('systemID');
        if (!empty($systemID)) {
            $args['systemID'] = $systemID;
        }

        $constellationID = $eve->VarCleanFromInput('constellationID');
        if (!empty($constellationID)) { //echo $constellationID;exit;
            $args['constellationID'] = $constellationID;
        }

        $regionID = $eve->VarCleanFromInput('regionID');
        if (!empty($regionID)) { //echo $regionID;exit;
            $args['regionID'] = $regionID;
        }

        //echo '<pre>';print_r($pos_ids); echo '</pre>';exit;
    } else {
        $pos_id = $eve->VarCleanFromInput('pos_id');
        if (!empty($pos_id) && is_numeric($pos_id)) {
            $args['pos_ids'][] = $pos_id;
        }

        $systemID = $eve->VarCleanFromInput('systemID');
        if (!empty($systemID)) {
            $args['systemID'] = $systemID;
        }

        $constellationID = $eve->VarCleanFromInput('constellationID');
        if (!empty($constellationID)) {
            $args['constellationID'] = $constellationID;
        }

        $regionID = $eve->VarCleanFromInput('regionID');
        if (!empty($regionID)) { //echo $regionID;exit;
            $args['regionID'] = $regionID;
        }
    }

    if (!isset($days_to_refuel) || empty($days_to_refuel)) {
        $days_to_refuel = $default_days;
    }


    $regions = $posmgmt->GetInstalledRegions();
    $constellations = $posmgmt->GetConstellationsWithPos();
    $systems = $posmgmt->GetSystemsWithPos();

    $optregions[] = 'All Regions';
    foreach ($regions as $regID => $region) {
        $optregions[$regID] = $region['regionName'];
    }

    $optconstellations[] = 'All Constellations';
    foreach ($constellations as $constID => $constellation) {
        $optconstellations[$constellation['constellationID']] = $constellation['constellationName'];
    }

    $optsystems[] = 'All Systems';
    foreach ($systems as $sysID => $system) {
        $optsystems[$system['solarSystemID']] = $system['solarSystemName'];
    }

    $optlevels = array(1 => 'Current Level - Yes', 0 => 'Current Level - No');

    $eveRender->Assign('regions',            $regions);
    $eveRender->Assign('optregions',         $optregions);
    $eveRender->Assign('constellations',     $constellations);
    $eveRender->Assign('optconstellations',  $optconstellations);
    $eveRender->Assign('systems',            $systems);
    $eveRender->Assign('optsystems',         $optsystems);
    $eveRender->Assign('default_days',       $default_days);
    $eveRender->Assign('days_to_refuel',     $days_to_refuel);
    $eveRender->Assign('regionID',           $regionID);
    $eveRender->Assign('constellationID',    $constellationID);
    $eveRender->Assign('systemID',           $systemID);
    $eveRender->Assign('use_current_levels', $use_current_levels);
    $eveRender->Assign('optlevels',          $optlevels);
    $eveRender->Assign('optposids',          $optposids);

    $count = 0;
    $args['use_current_levels'] = $use_current_levels;
    $towers = $posmgmt->GetFuelBill($args);

    foreach ($towers as $key => $tower) {

        // Users with Access below 3 -> Only Display the Tower if they are Fuel Tech for it.
        if ($access <= "2") {
			if ($tower['owner_id'] != $userinfo['eve_id'] && $tower['secondary_owner_id'] != $userinfo['eve_id']) {
            continue ;
			}
        }
		else {
			if ($tower['secret_pos'] == 1 && $access != 5) { //Secret POS Access Check. Will go through if highly trusted or are a fuel tech of the tower.
				if ($highly_trusted != 1 && $tower['owner_id'] != $userinfo['eve_id'] && $tower['secondary_owner_id'] != $userinfo['eve_id']) {
				continue ;
				}
			}
		}
		
        $required_H_isotope  = 0;
        $required_N_isotope  = 0;
        $required_O_isotope  = 0;
        $required_Hy_isotope = 0;

        $system                   = $tower['system'];
        $needed_uranium           = $tower['needed_uranium'];
        $needed_oxygen            = $tower['needed_oxygen'];
        $needed_mechanical_parts  = $tower['needed_mechanical_parts'];
        $needed_coolant           = $tower['needed_coolant'];
        $needed_robotics          = $tower['needed_robotics'];
        $needed_isotopes          = $tower['needed_isotopes'];
        $needed_ozone             = $tower['needed_ozone'];
        $needed_heavy_water       = $tower['needed_heavy_water'];
        $needed_charters          = $tower['needed_charters'];
        $needed_stront            = $tower['needed_stront'];
        $pos_id                   = $tower['pos_id'];
        $pos_race                 = $tower['pos_race'];
        $locationName             = $tower['locationName'];
        $tower['constellationName'] = $posmgmt->getConstellationNameFromMoonID($locationName);
        $tower['regionName']      = $posmgmt->getRegionNameFromMoonID($locationName);

        switch($pos_race) {
            case 1:  $required_H_isotope  = $tower['needed_isotopes']; break;
            case 6:  $required_H_isotope  = $tower['needed_isotopes']; break;
            case 7:  $required_H_isotope  = $tower['needed_isotopes']; break;
            case 11: $required_H_isotope  = $tower['needed_isotopes']; break;
            case 14: $required_H_isotope  = $tower['needed_isotopes']; break;
            case 4:  $required_Hy_isotope = $tower['needed_isotopes']; break;
            case 5:  $required_Hy_isotope = $tower['needed_isotopes']; break;
            case 8:  $required_Hy_isotope = $tower['needed_isotopes']; break;
            case 2:  $required_N_isotope  = $tower['needed_isotopes']; break;
            case 9:  $required_N_isotope  = $tower['needed_isotopes']; break;
            case 10: $required_N_isotope  = $tower['needed_isotopes']; break;
            case 3:  $required_O_isotope  = $tower['needed_isotopes']; break;
            case 12: $required_O_isotope  = $tower['needed_isotopes']; break;
            case 13: $required_O_isotope  = $tower['needed_isotopes']; break;
        }
        $tower['required_H_isotope']  = $required_H_isotope;
        $tower['required_Hy_isotope'] = $required_Hy_isotope;
        $tower['required_N_isotope']  = $required_N_isotope;
        $tower['required_O_isotope']  = $required_O_isotope;

        $fuel_H_isotopes        = $fuel_H_isotopes        + $required_H_isotope;
        $fuel_N_isotopes        = $fuel_N_isotopes        + $required_N_isotope;
        $fuel_O_isotopes        = $fuel_O_isotopes        + $required_O_isotope;
        $fuel_Hy_isotopes       = $fuel_Hy_isotopes       + $required_Hy_isotope;
        $fuel_uranium           = $fuel_uranium           + $needed_uranium;
        $fuel_oxygen            = $fuel_oxygen            + $needed_oxygen;
        $fuel_mechanical_parts  = $fuel_mechanical_parts  + $needed_mechanical_parts;
        $fuel_coolant           = $fuel_coolant           + $needed_coolant;
        $fuel_robotics          = $fuel_robotics          + $needed_robotics;
        $fuel_ozone             = $fuel_ozone             + $needed_ozone;
        $fuel_heavy_water       = $fuel_heavy_water       + $needed_heavy_water;

        $disp_towers[$key] = $tower;
    }

    (integer) $fuel_uranium_size          = round($fuel_uranium           * $pos_Ura);
    (integer) $fuel_oxygen_size           = round($fuel_oxygen            * $pos_Oxy);
    (float)   $fuel_mechanical_parts_size = round($fuel_mechanical_parts  * $pos_Mec);
    (integer) $fuel_coolant_size          = round($fuel_coolant           * $pos_Coo);
    (integer) $fuel_robotics_size         = round($fuel_robotics          * $pos_Rob);
    (integer) $fuel_H_isotopes_size       = round($fuel_H_isotopes        * $pos_Iso);
    (integer) $fuel_N_isotopes_size       = round($fuel_N_isotopes        * $pos_Iso);
    (integer) $fuel_O_isotopes_size       = round($fuel_O_isotopes        * $pos_Iso);
    (integer) $fuel_Hy_isotopes_size      = round($fuel_Hy_isotopes       * $pos_Iso);
    (integer) $fuel_ozone_size            = round($fuel_ozone             * $pos_Ozo);
    (integer) $fuel_heavy_water_size      = round($fuel_heavy_water       * $pos_Hea);
    //(integer) $fuel_strontium_size        = round($current_strontium * 3) ;
    $total_size = $fuel_uranium_size + $fuel_oxygen_size + $fuel_mechanical_parts_size + $fuel_coolant_size + $fuel_robotics_size + $fuel_H_isotopes_size + $fuel_N_isotopes_size + $fuel_O_isotopes_size + $fuel_Hy_isotopes_size + $fuel_ozone_size + $fuel_heavy_water_size;

    $eveRender->Assign('fuel_uranium_size',           $fuel_uranium_size);
    $eveRender->Assign('fuel_oxygen_size',            $fuel_oxygen_size);
    $eveRender->Assign('fuel_mechanical_parts_size',  $fuel_mechanical_parts_size);
    $eveRender->Assign('fuel_coolant_size',           $fuel_coolant_size);
    $eveRender->Assign('fuel_robotics_size',          $fuel_robotics_size);
    $eveRender->Assign('fuel_H_isotopes_size',        $fuel_H_isotopes_size);
    $eveRender->Assign('fuel_N_isotopes_size',        $fuel_N_isotopes_size);
    $eveRender->Assign('fuel_O_isotopes_size',        $fuel_O_isotopes_size);
    $eveRender->Assign('fuel_N_isotopes_size',        $fuel_N_isotopes_size);
    $eveRender->Assign('fuel_Hy_isotopes_size',       $fuel_Hy_isotopes_size);
    $eveRender->Assign('fuel_ozone_size',             $fuel_ozone_size);
    $eveRender->Assign('fuel_heavy_water_size',       $fuel_heavy_water_size);
    $eveRender->Assign('fuel_H_isotopes',             $fuel_H_isotopes);
    $eveRender->Assign('fuel_N_isotopes',             $fuel_N_isotopes);
    $eveRender->Assign('fuel_O_isotopes',             $fuel_O_isotopes);
    $eveRender->Assign('fuel_Hy_isotopes',            $fuel_Hy_isotopes);
    $eveRender->Assign('fuel_uranium',                $fuel_uranium);
    $eveRender->Assign('fuel_oxygen',                 $fuel_oxygen);
    $eveRender->Assign('fuel_uranium',                $fuel_uranium);
    $eveRender->Assign('fuel_mechanical_parts',       $fuel_mechanical_parts);
    $eveRender->Assign('fuel_coolant',                $fuel_coolant);
    $eveRender->Assign('fuel_robotics',               $fuel_robotics);
    $eveRender->Assign('fuel_ozone',                  $fuel_ozone);
    $eveRender->Assign('fuel_heavy_water',            $fuel_heavy_water);
    $eveRender->Assign('total_size',                  $total_size);
    $eveRender->Assign('towers',                      $disp_towers);
    //echo '<pre>';print_r($disp_towers); echo '</pre>';exit;

    $eveRender->Display('fuelbill.tpl');

} else {

  $eve->SessionSetVar('errormsg', 'Access Denied - Redirecting you back!');
  $eve->RedirectUrl('track.php');

}




?>
