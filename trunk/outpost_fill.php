<?php
/**
 * Pos-Tracker2
 *
 * Outpost fill page
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

require_once 'config.php';
require_once 'functions.php';
require_once 'header.php';
include_once 'includes/pos_val.php';


/* --- By default the form is displayed --- */
if (in_array('1', $access) || in_array('5', $access)) {
	
/* -- Data settings and controls -- */

	$outpost_to_refuel  = (integer) $_POST['outpost_to_refuel'] ;
	$days_to_refuel     = (integer) $_POST['days'] ;
	$hours_to_refuel    = (integer) $_POST['hours'] ;
	$use_current_levels = (boolean) $_POST['use_current_levels'] ;
	$size_of_hauler		= (integer) $_POST['size'] ;
	
/* -- check for varible entry -- */
if ($outpost_to_refuel > 0) {

/* -- Fuel calculation -- */
	$current_isotope = $current_oxygen = $current_mechanical_parts = $current_coolant = $current_robotics = $current_uranium = $current_ozone = $current_heavy_water = $current_strontium = $current_charters = 0;

	$sql = "SELECT * FROM ".TBL_PREFIX."outpost_info WHERE outpost_id = '" . my_escape($outpost_to_refuel) . "'"; 
	$result = mysql_query($sql) 
		or die('Error retrieving from pos_info in function uptimecal1;' . mysql_error()) ;

			$uptimecalc=outpost($outpost_to_refuel);
			// new code to support difference raical full
			$required_heisotope = $uptimecalc["required_heisotope"];
			$required_hyisotope = $uptimecalc["required_hyisotope"];
			$required_oxisotope = $uptimecalc["required_oxisotope"];
			$required_niisotope = $uptimecalc["required_niisotope"];
			// end new code
			$required_oxygen = $uptimecalc["required_oxy"];
			$required_mechanical_parts = $uptimecalc["required_mech"];
			$required_coolant = $uptimecalc["required_cool"];
			$required_robotics = $uptimecalc["required_robo"];
			$required_uranium = $uptimecalc["required_ura"];
			$required_ozone2 = $uptimecalc["required_ozo"];
			$required_heavy_water2 = $uptimecalc["required_hea"];
			$required_strontium = $uptimecalc["required_stront"];
			$required_charters = $uptimecalc["required_chart"];
			$outpost_heisotope = $uptimecalc["overall_heisotope"];
			$outpost_hyisotope = $uptimecalc["overall_hyisotope"];
			$outpost_oxisotope = $uptimecalc["overall_oxisotope"];
			$outpost_niisotope = $uptimecalc["overall_niisotope"];
			$outpost_oxygen = $uptimecalc["overall_oxy"];
			$outpost_mechanical_parts = $uptimecalc["overall_mech"];
			$outpost_coolant = $uptimecalc["overall_cool"];
			$outpost_robotics = $uptimecalc["overall_robo"];
			$outpost_uranium = $uptimecalc["overall_uran"];
			$outpost_ozone = $uptimecalc["overall_ozo"];
			$outpost_heavy_water = $uptimecalc["overall_heavy"];
			$outpost_strontium = $uptimecalc["overall_stron"];
			$overall_total_strontium_hanger = $uptimecalc["overall_stron_hanger"];
			$outpost_charters = $uptimecalc["overall_chart"];
			$current_pg = $uptimecalc["current_pg"];
			$current_cpu = $uptimecalc["current_cpu"];
			$total_pg = $uptimecalc["total_pg"];
			$total_cpu = $uptimecalc["total_cpu"];
			#added to allow for info on the refill page
			$sql = "SELECT * FROM ".TBL_PREFIX."outpost_info WHERE outpost_id = '" .  my_escape($outpost_to_refuel) . "'";
			$result = mysql_query($sql)
				or die('Error retrieving from outpost_info in function uptimecalc;' . mysql_error());
			if ($row = mysql_fetch_array($result)) {
			$outpost_name = $row['outpost_name'];
			$systemID=$row['systemID'];
			$hoursago = outposthoursago($outpost_to_refuel, 1);
			}


/* --- Needed fuel calculation --- */

	$needed_hours = (integer) (abs($days_to_refuel*24) + abs($hours_to_refuel)) ; 
	$real_required_ozone        = ceil(($current_pg / $total_pg) * $required_ozone2) ;  
	$real_required_heavy_water  = ceil(($current_cpu / $total_cpu) * $required_heavy_water2) ;

	$total_uranium          = $required_uranium * $needed_hours ;
	$total_oxygen           = $required_oxygen * $needed_hours ;
	$total_mechanical_parts = $required_mechanical_parts * $needed_hours ;
	$total_coolant          = $required_coolant * $needed_hours ;
	$total_robotics         = $required_robotics * $needed_hours ;
	$total_heisotopes       = $required_heisotope * $needed_hours ;
	$total_hyisotopes       = $required_hyisotope * $needed_hours ;
	$total_oxisotopes       = $required_oxisotope * $needed_hours ;
	$total_niisotopes       = $required_niisotope * $needed_hours ;
	$total_ozone            = $real_required_ozone * $needed_hours ;
	$total_heavy_water      = $real_required_heavy_water * $needed_hours ;
	$total_charters         = $required_charters * $needed_hours;
	$total_stront			= $required_strontium * $needed_hours;


	$needed_uranium          = $required_uranium * $needed_hours ;
	$needed_oxygen           = $required_oxygen * $needed_hours ;
	$needed_mechanical_parts = $required_mechanical_parts * $needed_hours ;
	$needed_coolant          = $required_coolant * $needed_hours ;
	$needed_robotics         = $required_robotics * $needed_hours ;
	$needed_heisotopes       = $required_heisotope * $needed_hours ;
	$needed_hyisotopes       = $required_hyisotope * $needed_hours ;
	$needed_oxisotopes       = $required_oxisotope * $needed_hours ;
	$needed_niisotopes       = $required_niisotope * $needed_hours ;
	$needed_ozone            = $real_required_ozone * $needed_hours ;
	$needed_heavy_water      = $real_required_heavy_water * $needed_hours ;
	$needed_charters         = $required_charters * $needed_hours;
	$needed_stront			 = $required_strontium * $needed_hours;
	
	



	if ($use_current_levels) {
		$needed_uranium          = $needed_uranium - $outpost_uranium ;
		$needed_oxygen           = $needed_oxygen - $outpost_oxygen ;
		$needed_mechanical_parts = $needed_mechanical_parts - $outpost_mechanical_parts ;
		$needed_coolant          = $needed_coolant - $outpost_coolant ;
		$needed_robotics         = $needed_robotics - $outpost_robotics ;
		$needed_heisotope        = $needed_heisotopes - $outpost_heisotope ;
		$needed_hyisotope        = $needed_hyisotopes - $outpost_hyisotope ;
		$needed_oxisotope        = $needed_oxisotopes - $outpost_oxisotope ;
		$needed_niisotope        = $needed_niisotopes - $outpost_niisotope ;
		$needed_ozone            = $needed_ozone - $outpost_ozone ;
		$needed_heavy_water      = $needed_heavy_water - $outpost_heavy_water ;
		$needed_charters         = $needed_charters - $outpost_charters;
		$needed_stront			 = $needed_stront - $outpost_strontium;
			
	}

	if ($needed_uranium < 0) {
		$needed_uranium = 0;
	}
	if ($needed_oxygen < 0) {
		$needed_oxygen = 0;
	}
	if ($needed_mechanical_parts < 0) {
		$needed_mechanical_parts = 0;
	}
	if ($needed_coolant < 0) {
		$needed_coolant = 0;
	}
	if ($needed_robotics < 0) {
		$needed_robotics = 0;
	}
	if ($needed_heisotopes < 0) {
		$needed_heisotopes = 0;
	}
	if ($needed_hyisotopes < 0) {
		$needed_hyisotopes = 0;
	}
	if ($needed_oxisotopes < 0) {
		$needed_oxisotopes = 0;
	}
	if ($needed_niisotopes < 0) {
		$needed_niisotopes = 0;
	}
	if ($needed_ozone < 0) {
		$needed_ozone = 0;
	}
	if ($needed_heavy_water < 0) {
		$needed_heavy_water = 0;
	}
	if ($needed_charters < 0 ) {
		$needed_charters = 0;
	}
	if ($needed_stront < 0 ) {
		$needed_stront = 0;
	}

	$needed_uranium_size          = $needed_uranium * $pos_Ura; 
	$needed_oxygen_size           = $needed_oxygen  * $pos_Oxy;
	$needed_mechanical_parts_size = $needed_mechanical_parts * $pos_Mec;
	$needed_coolant_size          = $needed_coolant *  $pos_Coo;
	$needed_robotics_size         = $needed_robotics * $pos_Rob;
	$needed_heisotopes_size       = $needed_heisotopes * $pos_Iso; 
	$needed_hyisotopes_size       = $needed_hyisotopes * $pos_Iso;
	$needed_oxisotopes_size       = $needed_oxisotopes * $pos_Iso;
	$needed_niisotopes_size       = $needed_niisotopes * $pos_Iso;
	$needed_ozone_size            = $needed_ozone *  $pos_Ozo;
	$needed_heavy_water_size      = $needed_heavy_water * $pos_Hea;
	$needed_charter_size          = $needed_charters * $pos_Cha;
	$needed_stront_size			  = $needed_stront * $pos_Str;

	$total_volume = 0 ;
	$total_volume = $needed_uranium_size + $needed_oxygen_size + $needed_mechanical_parts_size + $needed_coolant_size + $needed_robotics_size  +  $needed_heisotopes_size +  $needed_hyisotopes_size +  $needed_oxisotopes_size +  $needed_biisotopes_size + $needed_ozone_size + $needed_heavy_water_size + $needed_charter_size + $needed_stront_size ;
		// pulls the date of last update for display purposes
		$sql = "SELECT * FROM ".TBL_PREFIX."outpost_update_log WHERE outpost_id = '" . my_escape($outpost_to_refuel) . "' ORDER BY id DESC";
		$result2 = mysql_query($sql)
			or die('Could not select from outpost_update_log; ' . mysql_error());
		$row2 = mysql_fetch_array($result2);
		
			// added more details to be displayed sence there will be more than 1 outpost being shown
		$last_update = gmdate("Y-m-d H:i:s", $row2['datetime']);
		echo "<table width='893' border='0'><tr><td width='120' height='15'><div align='left'>Last Updated: </div></td><td width='210'><div align='left'>" . $last_update . "</div></td><td width='509'><div align='left'></div></td></tr>";
		echo "<tr><td><div align='left'>Was updated: </div></td><td><div align='left'>" . $hoursago . " Hours Ago</div></td><td><div align='left'></div></td></tr>";
		echo "<tr><td><div align='left'>Outpost Name: </div></td><td><div align='left'>" .$outpost_name . "</div></td><td><div align='left'></div></td></tr>";
//Print System name and outpost Name		
		echo "<tr><td><div align='left'>System Name: </div></td><td><div align='left'>" . $systemID . "</div></td><td><div align='left'></div></td></tr></table><br>";




	echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"5\" width=\"310\">";
	echo "<tr><td>Fuel</td><td>Total Required</td><td>You need</td><td><div style=\"text-align: center; float; center\">Volume</div></td></tr>";
	echo "<tr><td>Enriched Uranium</td><td>" . $total_uranium . "</td><td>" . $needed_uranium . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_uranium_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Oxygen</td><td>" . $total_oxygen . "</td><td>" . $needed_oxygen . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_oxygen_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Mechanical Parts</td><td>" . $total_mechanical_parts . "</td><td>" . $needed_mechanical_parts . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_mechanical_parts_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Coolant</td><td>" . $total_coolant . "</td><td>" . $needed_coolant . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_coolant_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Robotics</td><td>" . $total_robotics . "</td><td>" . $needed_robotics . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_robotics_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>" . $race_isotope . "Helium Isotopes</td><td>" . $total_heisotopes . "</td><td>" . $needed_heisotopes . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_heisotopes_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>" . $race_isotope . "Hydrogen Isotopes</td><td>" . $total_hyisotopes . "</td><td>" . $needed_hyisotopes . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_hyisotopes_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>" . $race_isotope . "Oxygen Isotopes</td><td>" . $total_oxisotopes . "</td><td>" . $needed_oxisotopes . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_oxisotopes_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>" . $race_isotope . "Nitrogen Isotopes</td><td>" . $total_niisotopes . "</td><td>" . $needed_niisotopes . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_niisotopes_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Liquid Ozone</td><td>" . $total_ozone . "</td><td>" . $needed_ozone . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_ozone_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>Heavy Water</td><td>" . $total_heavy_water . "</td><td>" . $needed_heavy_water . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_heavy_water_size)*1),2)." m3)</div></td></tr>";
	if ($charters_needed) {
		echo "<tr><td>Charters</td><td>" . $total_charters . "</td><td>" . $needed_charters . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_charters)*0.1),2)." m3)</div></td></tr>";
		}
	echo "<tr><td>Strontium</td><td>" . $total_stront . "</td><td>" . $needed_stront . "</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($needed_stront_size)*1),2)." m3)</div></td></tr>";
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>Total</td><td width=\"85\"><div style=\"text-align: right; float: right\">(".number_format((($total_volume)*1),2)." m3)</div></td></tr>";
	echo "</table>";
	echo "<br>";
	$trips = ceil($total_volume / $size_of_hauler);
	if ($trips > 1) {
		$ending = " trips";
	} else {
		$ending = " trip";
	}
	echo "Given a hauler size of " . $size_of_hauler . "m3 you will need to make " . $trips . $ending;
	
	
#end part of the check for empty data
} else {
	echo "You did not select a Outpost to refill, Please go back and try again.";
}
}

require_once 'footer.php';
?>