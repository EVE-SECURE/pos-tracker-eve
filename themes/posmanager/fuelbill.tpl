<!--[* $Id: fuelbill.tpl 215 2008-11-17 10:53:10Z eveoneway $ *]-->
<!--[include file='header.tpl']-->

  <h3 class="pageTitle"><!--[$days_to_refuel]--> Days Fuel bill</h3>
  <form style="text-align: center;" method="post" action="fuelbill.php">
  <p style="text-align:center;">
    <span style="color:#1B3169;">Days <input name="days_to_refuel" size="5" value="<!--[$days_to_refuel]-->" type="text" /></span>
    <!--[html_options name='regionID'           options=$optregions selected=$regionID]-->
    <!--[if $access > 2 ]-->
	<!--[html_options name='constellationID'    options=$optconstellations selected=$constellationID]-->
	<!--[html_options name='systemID'           options=$optsystems selected=$systemID]-->
    <!--[/if]-->
    <!--[html_options name='use_current_levels' options=$optlevels  selected=$use_current_levels]-->
    <input type="submit" name="submit" value="Filter" /> - <a href="fuelbill.php" title="Clear Filter">Clear Filter</a>
  </p>

  <table cellspacing="0" class="mcenter" style="width:90%; padding:5px; font:11px Arial, sans-serif;">
    <tr style="background-color:#336699;">
      <td class="arialwhite12 billheader">POS_ID</td>
      <td class="arialwhite12 billheader">Region</td>
      <td class="arialwhite12 billheader">Constellation</td>
      <td class="arialwhite12 billheader">POS</td>
      <td class="arialwhite12 billheader">Sov</td>
      <td class="arialwhite12 billheader">En Uranium</td>
	  <td class="arialwhite12 billheader">Oxygen</td>
	  <td class="arialwhite12 billheader">Mech Parts</td>
      <td class="arialwhite12 billheader">Coolant</td>
      <td class="arialwhite12 billheader">Robotics</td>
	  <td class="arialwhite12 billheader">Helium Isotope</td>
      <td class="arialwhite12 billheader">Hydrogen Isotope</td>
      <td class="arialwhite12 billheader">Nitrogen Isotope</td>
      <td class="arialwhite12 billheader">Oxygen Isotope</td>
	  <td class="arialwhite12 billheader">Liquid Ozone</td>
	  <td class="arialwhite12 billheader">Heavy Water</td>
      <td class="arialwhite12 billheader">&nbsp;</td>
    </tr>

  <!--[assign var='linecount' value=1]-->
  <!--[foreach item='pos' from=$towers]-->
  <!--[if $linecount eq 10]-->
    <tr style="background-color:#336699;">
      <td class="arialwhite12 billheader">POS_ID</td>
      <td class="arialwhite12 billheader">Region</td>
      <td class="arialwhite12 billheader">Constellation</td>
      <td class="arialwhite12 billheader">POS</td>
      <td class="arialwhite12 billheader">Sov</td>
      <td class="arialwhite12 billheader">En Uranium</td>
	  <td class="arialwhite12 billheader">Oxygen</td>
	  <td class="arialwhite12 billheader">Mech Parts</td>
      <td class="arialwhite12 billheader">Coolant</td>
      <td class="arialwhite12 billheader">Robotics</td>
	  <td class="arialwhite12 billheader">Helium Isotope</td>
      <td class="arialwhite12 billheader">Hydrogen Isotope</td>
      <td class="arialwhite12 billheader">Nitrogen Isotope</td>
      <td class="arialwhite12 billheader">Oxygen Isotope</td>
	  <td class="arialwhite12 billheader">Liquid Ozone</td>
	  <td class="arialwhite12 billheader">Heavy Water</td>
      <td class="arialwhite12 billheader">&nbsp;</td>
    </tr>
    <!--[assign var='linecount' value=1]-->
  <!--[/if]-->
    <tr<!--[if $pos.pos_status eq 1]--> style="background-color:red;"<!--[/if]-->>
      <td class="billcontent"><!--[$pos.pos_id]--></td>
      <td class="billcontent"><!--[$pos.regionName]--></td>
      <td class="billcontent"><!--[$pos.constellationName]--></td>
      <td class="billcontent"><a style="color:#1B3169;" href="viewpos.php?i=<!--[$pos.pos_id]-->" title="<!--[$pos.locationName]-->"><!--[$pos.locationName]--></a></td>
      <td class="billcontent"><!--[$pos.sovereignty]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.needed_uranium]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.needed_oxygen]--></td>
	  <td class="billcontent"><!--[formatnumber value=$pos.needed_mechanical_parts]--></td>
	  <td class="billcontent"><!--[formatnumber value=$pos.needed_coolant]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.needed_robotics]--></td>
	  <td class="billcontent"><!--[formatnumber value=$pos.required_H_isotope]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.required_Hy_isotope]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.required_N_isotope]--></td>
      <td class="billcontent"><!--[formatnumber value=$pos.required_O_isotope]--></td>
	  <td class="billcontent"><!--[formatnumber value=$pos.needed_ozone]--></td>
	  <td class="billcontent"><!--[formatnumber value=$pos.needed_heavy_water]--></td>
      <td class="billcontent"><input type="checkbox" name="pos_ids[<!--[$pos.pos_id]-->]" <!--[if $optposids[$pos.pos_id]]-->checked="checked" <!--[/if]-->/></td>
    </tr>
    <!--[math equation="x+y" x=$linecount y=1 assign='linecount']-->
  <!--[/foreach]-->

    <tr>
      <td class="billcontent" colspan="5" style="text-align:left;">Total m3</td>
      <td class="billcontent"><!--[formatnumber value=$fuel_uranium_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_oxygen_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_mechanical_parts_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_coolant_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_robotics_size]--></td>
	  <td class="billcontent"><!--[formatnumber value=$fuel_H_isotopes_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_Hy_isotopes_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_N_isotopes_size]--></td>
      <td class="billcontent"><!--[formatnumber value=$fuel_O_isotopes_size]--></td>
	  <td class="billcontent"><!--[formatnumber value=$fuel_ozone_size]--></td>
	  <td class="billcontent"><!--[formatnumber value=$fuel_heavy_water_size]--></td>
	  <td class="arialwhite12">&nbsp;</td>
    </tr>

    <tr>
      <td style="background-color:#336699; color:#CCCCCC; text-align:left;" class="billcontent" colspan="5">Totals</td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_uranium]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_oxygen]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_mechanical_parts]--></td>
	  <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_coolant]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_robotics]--></td>
	  <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_H_isotopes]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_Hy_isotopes]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_N_isotopes]--></td>
      <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_O_isotopes]--></td>
	  <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_ozone]--></td>
	  <td style="background-color:#336699; color:#CCCCCC;" class="billcontent"><!--[formatnumber value=$fuel_heavy_water]--></td>
      <td class="arialwhite12">&nbsp;</td>
	  <td class="arialwhite12">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="16" class="billcontent" style="text-align:center;"><!--[formatnumber value=$total_size]--> (m3)</td>
    </tr>
  </table>
  <p style="text-align:center;"><input type="submit" name="filter" value="Filter" /> - <a href="fuelbill.php" title="Clear Filter">Clear Filter</a></p>
  </form>
  <p>
    <textarea name="fuel Bill" cols="50" rows="15">
Enriched Uranium: <!--[formatnumber value=$fuel_uranium]--> (<!--[formatnumber value=$fuel_uranium_size]-->m3)
Oxygen: <!--[formatnumber value=$fuel_oxygen]--> (<!--[formatnumber value=$fuel_oxygen_size]-->m3)
Mechanical Parts: <!--[formatnumber value=$fuel_mechanical_parts]--> (<!--[formatnumber value=$fuel_mechanical_parts_size]-->m3)
Coolant: <!--[formatnumber value=$fuel_coolant]--> (<!--[formatnumber value=$fuel_coolant_size]-->m3)
Robotics: <!--[formatnumber value=$fuel_robotics]--> (<!--[formatnumber value=$fuel_robotics_size]-->m3)
Helium Isotopes: <!--[formatnumber value=$fuel_H_isotopes]--> (<!--[formatnumber value=$fuel_H_isotopes_size]-->m3)
Hydrogen Isotopes: <!--[formatnumber value=$fuel_Hy_isotopes]--> (<!--[formatnumber value=$fuel_Hy_isotopes_size]-->m3)
Nitrogen Isotopes: <!--[formatnumber value=$fuel_N_isotopes]--> (<!--[formatnumber value=$fuel_N_isotopes_size]-->m3)
Oxygen Isotopes: <!--[formatnumber value=$fuel_O_isotopes]--> (<!--[formatnumber value=$fuel_O_isotopes_size]-->m3)
Liquid Ozone: <!--[formatnumber value=$fuel_ozone]--> (<!--[formatnumber value=$fuel_ozone_size]-->m3)
Heavy Water: <!--[formatnumber value=$fuel_heavy_water]--> (<!--[formatnumber value=$fuel_heavy_water_size]-->m3)
Total in m3: <!--[formatnumber value=$total_size]-->
</textarea>
  </p>


<!--[include file='footer.tpl']-->
