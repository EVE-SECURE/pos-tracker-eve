<?php
/**
 * Pos-Tracker2
 *
 * Starbase Fuel calculator page
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
 * @version    SVN: $Id: fuel_calculator.php 243 2009-04-26 16:10:33Z stephenmg $
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
include_once 'eveconfig/config.php';
$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();

$access = $eve->SessionGetVar('access');
$eveRender->Assign('access', $access);

$pos_to_refuel = $eve->VarCleanFromInput('pos_to_refuel');

if (!empty($pos_to_refuel)) {
    $days               = $eve->VarCleanFromInput('days');
    $hours              = $eve->VarCleanFromInput('hours');
    $use_current_levels = $eve->VarCleanFromInput('use_current_levels');
    $use_hanger_levels  = 0;//$eve->VarCleanFromInput('use_hanger_levels');
    $cargosize          = $eve->VarCleanFromInput('size');

    //$tower = $posgmt->GetTowerInfo($pos_to_refuel);

    $args['days_to_refuel']     = $days + ($hours/24);
    $args['pos_ids'][]          = $pos_to_refuel;
    $args['use_current_levels'] = $use_current_levels;

    $bill = $posmgmt->GetFuelBill($args);

    $tower = $bill[$pos_to_refuel];

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

    $fuel = array('fuel_H_isotopes'             => $fuel_H_isotopes,
                  'fuel_N_isotopes'             => $fuel_N_isotopes,
                  'fuel_O_isotopes'             => $fuel_O_isotopes,
                  'fuel_Hy_isotopes'            => $fuel_Hy_isotopes,
                  'fuel_uranium'                => $fuel_uranium,
                  'fuel_oxygen'                 => $fuel_oxygen,
                  'fuel_mechanical_parts'       => $fuel_mechanical_parts,
                  'fuel_coolant'                => $fuel_coolant,
                  'fuel_robotics'               => $fuel_robotics,
                  'fuel_ozone'                  => $fuel_ozone,
                  'fuel_heavy_water'            => $fuel_heavy_water,
                  'fuel_uranium_size'           => $fuel_uranium_size,
                  'fuel_oxygen_size'            => $fuel_oxygen_size,
                  'fuel_mechanical_parts_size'  => $fuel_mechanical_parts_size,
                  'fuel_coolant_size'           => $fuel_coolant_size,
                  'fuel_robotics_size'          => $fuel_robotics_size,
                  'fuel_H_isotopes_size'        => $fuel_H_isotopes_size,
                  'fuel_N_isotopes_size'        => $fuel_N_isotopes_size,
                  'fuel_O_isotopes_size'        => $fuel_O_isotopes_size,
                  'fuel_Hy_isotopes_size'       => $fuel_Hy_isotopes_size,
                  'fuel_ozone_size'             => $fuel_ozone_size,
                  'fuel_heavy_water_size'       => $fuel_heavy_water_size,
                  'total_size'                  => $total_size);

    $fuel = array_merge($fuel, $tower);

    if($cargosize > 0) {
        $fuel['trips'] = ceil($total_size / $cargosize);
    }

    $eveRender->Assign('fuel',           $fuel);
    $eveRender->Assign('hours',          $hours);
    $eveRender->Assign('cargosize',      $cargosize);
    $eveRender->Assign('pos_to_refuel',  $pos_to_refuel);
    $eveRender->Assign('days_to_refuel', $args['days_to_refuel']);

    //echo '<pre>';print_r($fuel); echo '</pre>';exit;

}

$towers = $posmgmt->GetAllPos2();
$opttowers[0] = 'POS List';
foreach ($towers as $tower) {

    // Users with Access below 3 -> Only Display the Tower if they are Fuel Tech for it.
    if ($access <= "2") {
      if ($tower['owner_id'] != $userinfo['eve_id'] && $tower['secondary_owner_id'] != $userinfo['eve_id']) {
        continue ;
       }
    }

    $opttowers[$tower['pos_id']] = $tower['MoonName'] . ' - ' . $tower['towerName'];
}

$eveRender->Assign('opttowers', $opttowers);
//echo '<pre>';print_r($towers); echo '</pre>';exit;


$eveRender->Display('fuel_calc.tpl');
exit;

?>
