<!--[include file='header.tpl']-->
  <!--[if $days_to_refuel >= 1 && $display_optimal == 0]-->
  <b><!--[$days_to_refuel]--> Days Fuel Bill</b>
  <!--[else]-->
  <b>Optimal Fuel Bill</b> (days filter not in effect)
  <!--[/if]-->
  <form class="mcenter" method="post" action="fuelbill.php">
  <p style="text-align:center;">
    <span class="mcolor">Days <input name="days_to_refuel" size="5" value="<!--[$days_to_refuel]-->" type="text" /></span>
    <!--[html_options name='regionID'           options=$optregions selected=$regionID]-->
	<!--[html_options name='constellationID'    options=$optconstellations selected=$constellationID]-->
	<!--[html_options name='systemID'           options=$optsystems selected=$systemID]-->
    <!--[html_options name='use_current_levels' options=$optlevels  selected=$use_current_levels]-->
	<!--[html_options name='display_optimal' options=$disopt  selected=$display_optimal]-->
    <input class="mButton" type="submit" name="submit" value="Filter" /> - <a class="link" href="fuelbill.php" title="Clear Filter">Clear Filter</a>
  </p>

  <table cellspacing="0" class="mcenter" style="width:90%; padding:5px; font:11px Arial, sans-serif;">
    <tr class="mbground">
      <td class="hcolor billheader">POS_ID</td>
      <td class="hcolor billheader">Region</td>
      <td class="hcolor billheader">Constellation</td>
      <td class="hcolor billheader">POS</td>
      <td class="hcolor billheader">Sov</td>
      <td class="hcolor billheader">Amarr</td>
	  <td class="hcolor billheader">Caldari</td>
	  <td class="hcolor billheader">Gallente</td>
      <td class="hcolor billheader">Minmatar</td>
	  <td class="hcolor billheader">Charters</td>
	  <td class="hcolor billheader">Tower Name</td>
      <td class="hcolor billheader">&nbsp;</td>
    </tr>

  <!--[assign var='linecount' value=1]-->
  <!--[foreach item='pos' from=$towers]-->
  <!--[if $linecount eq 10]-->
    <tr class="mbground">
      <td class="hcolor billheader">POS_ID</td>
      <td class="hcolor billheader">Region</td>
      <td class="hcolor billheader">Constellation</td>
      <td class="hcolor billheader">POS</td>
      <td class="hcolor billheader">Sov</td>
      <td class="hcolor billheader">Amarr</td>
	  <td class="hcolor billheader">Caldari</td>
	  <td class="hcolor billheader">Gallente</td>
      <td class="hcolor billheader">Minmatar</td>
	  <td class="hcolor billheader">Charters</td>
	  <td class="hcolor billheader">Tower Name</td>
      <td class="hcolor billheader">&nbsp;</td>
    </tr>
    <!--[assign var='linecount' value=1]-->
  <!--[/if]-->
    <tr<!--[if $pos.pos_status eq 1]--> style="background-color:red;"<!--[/if]-->>
      <td class="billcontent"><!--[$pos.pos_id]--></td>
      <td class="billcontent"><!--[$pos.regionName]--></td>
      <td class="billcontent"><!--[$pos.constellationName]--></td>
      <td class="billcontent"><a class="link" href="viewpos.php?i=<!--[$pos.pos_id]-->" title="<!--[$pos.locationName]-->"><!--[$pos.locationName]--></a></td>
      <td class="billcontent" style="text-align:center;"><!--[if ($pos.sovfriendly)]--><img src="images/icons/sov.png"><!--[/if]--></td>
      <td class="billcontent"><!--[$pos.fuel_A_fuelblock]--></td>
	  <td class="billcontent"><!--[$pos.fuel_C_fuelblock]--></td>
	  <td class="billcontent"><!--[$pos.fuel_G_fuelblock]--></td>
	  <td class="billcontent"><!--[$pos.fuel_M_fuelblock]--></td>
	  <td class="billcontent"><!--[$pos.fuel_charters]--></td>
	  <td class="billcontent"><!--[$pos.towerName]--></td>
      <td class="billcontent"><input type="checkbox" name="pos_ids[<!--[$pos.pos_id]-->]" <!--[if $optposids[$pos.pos_id]]-->checked="checked" <!--[/if]-->/></td>
    </tr>
    <!--[math equation="x+y" x=$linecount y=1 assign='linecount']-->
  <!--[/foreach]-->
    <tr>
      <td class="billcontent" colspan="5" style="text-align:left;">Total m3</td>
	  <td class="billcontent"><!--[$fuel_A_total_size]--></td>
      <td class="billcontent"><!--[$fuel_C_total_size]--></td>
      <td class="billcontent"><!--[$fuel_G_total_size]--></td>
      <td class="billcontent"><!--[$fuel_M_total_size]--></td>
	  <td class="billcontent"><!--[formatnumber value=$charter_total_size]--></td>
	  <td class="hcolor">&nbsp;</td>
    </tr>
    <tr>
      <td class="billcontent mbground hcolor" style="text-align:left;" colspan="5">Totals</td>
	  <td class="billcontent mbground hcolor"><!--[$fuel_A_total]--></td>
      <td class="billcontent mbground hcolor"><!--[$fuel_C_total]--></td>
      <td class="billcontent mbground hcolor"><!--[$fuel_G_total]--></td>
      <td class="billcontent mbground hcolor"><!--[$fuel_M_total]--></td>
	  <td class="billcontent mbground hcolor"><!--[$charter_total]--></td>
      <td class="hcolor">&nbsp;</td>
	  <td class="hcolor">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="16" class="billcontent" style="text-align:center;"><!--[formatnumber value=$fb_total_size]--> (m3) | <!--[formatnumber value=$fb_total_cost]--> [isk]</td>
    </tr>
  </table>
  <p style="text-align:center;"><input class="mButton" type="submit" name="filter" value="Filter" /> - <a class="link" href="fuelbill.php" title="Clear Filter">Clear Filter</a></p>
  </form>
  
  <p>
<textarea name="fuel Bill" cols="75" rows="7">
Amarr Fuel Block: <!--[$fuel_A_total]--> (<!--[$fuel_A_total_size]-->m3) [<!--[formatnumber value=$amarrFB_cost]-->isk]
Caldari Fuel Block: <!--[$fuel_C_total]--> (<!--[$fuel_C_total_size]-->m3) [<!--[formatnumber value=$caldariFB_cost]-->isk]
Gallente Fuel Block: <!--[$fuel_G_total]--> (<!--[$fuel_G_total_size]-->m3) [<!--[formatnumber value=$gallenteFB_cost]-->isk]
Minmatar Fuel Block: <!--[$fuel_M_total]--> (<!--[$fuel_M_total_size]-->m3) [<!--[formatnumber value=$minmatarFB_cost]-->isk]

Total in m3: <!--[formatnumber value=$fb_total_size]-->
Total in isk: <!--[formatnumber value=$fb_total_cost]-->
</textarea>
 </p>
 
 Manufacturing:
  <p>
    <textarea name="fuel Bill" cols="75" rows="15">
Enriched Uranium: <!--[$fuel_uranium]--> (<!--[formatnumber value=$fuel_uranium_size]-->m3) [<!--[formatnumber value=$uranium_cost]-->isk]
Oxygen: <!--[$fuel_oxygen]--> (<!--[formatnumber value=$fuel_oxygen_size]-->m3) [<!--[formatnumber value=$oxygen_cost]-->isk]
Mechanical Parts: <!--[$fuel_mechanical_parts]--> (<!--[formatnumber value=$fuel_mechanical_parts_size]-->m3) [<!--[formatnumber value=$mechanical_parts_cost]-->isk]
Coolant: <!--[$fuel_coolant]--> (<!--[formatnumber value=$fuel_coolant_size]-->m3) [<!--[formatnumber value=$coolant_cost]-->isk]
Robotics: <!--[$fuel_robotics]--> (<!--[formatnumber value=$fuel_robotics_size]-->m3) [<!--[formatnumber value=$robotics_cost]-->isk]
Helium Isotopes: <!--[$fuel_H_isotopes]--> (<!--[formatnumber value=$fuel_H_isotopes_size]-->m3) [<!--[formatnumber value=$helium_iso_cost]-->isk]
Hydrogen Isotopes: <!--[$fuel_Hy_isotopes]--> (<!--[formatnumber value=$fuel_Hy_isotopes_size]-->m3) [<!--[formatnumber value=$hydrogen_iso_cost]-->isk]
Nitrogen Isotopes: <!--[$fuel_N_isotopes]--> (<!--[formatnumber value=$fuel_N_isotopes_size]-->m3) [<!--[formatnumber value=$nitrogen_iso_cost]-->isk]
Oxygen Isotopes: <!--[$fuel_O_isotopes]--> (<!--[formatnumber value=$fuel_O_isotopes_size]-->m3) [<!--[formatnumber value=$oxygen_iso_cost]-->isk]
Liquid Ozone: <!--[$fuel_ozone]--> (<!--[formatnumber value=$fuel_ozone_size]-->m3) [<!--[formatnumber value=$liquid_ozone_cost]-->isk]
Heavy Water: <!--[$fuel_heavy_water]--> (<!--[formatnumber value=$fuel_heavy_water_size]-->m3) [<!--[formatnumber value=$heavy_water_cost]-->isk]

Total in m3: <!--[formatnumber value=$total_size]-->
Total in isk: <!--[formatnumber value=$total_cost]-->
Manufacturing Time(4min): <!--[daycalc hours=$fuel_time]-->
</textarea>
 </p>


<!--[include file='footer.tpl']-->
