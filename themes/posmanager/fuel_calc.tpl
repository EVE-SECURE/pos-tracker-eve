<!--[include file='header.tpl']-->
  <h3 class="pageTitle">Fuel Calculator</h4>
  <form method="post" action="fuel_calculator.php">
  <div>
    <table class="mcenter tracktable" style="font-size: 12px;border-collapse:collapse;">
      <tr>
        <td class="mbground hcolor">POS To Refuel</td>
        <td><!--[html_options options=$opttowers name='pos_to_refuel' selected=$pos_to_refuel]--></td>
      </tr>
      <tr>
        <td class="mbground hcolor">X Days Y hour(s) worth of fuel</td>
        <td><input type="text" name="days" size="2" value="<!--[$days_to_refuel|default:"30"]-->" /> days <input type="text" name="hours" size="2" value="<!--[$hours]-->" /> hours</td>
      </tr>
      <tr>
        <td class="mbground hcolor">Use Current Level</td>
        <td>
		<!--[html_options name='use_current_levels' options=$optlevels  selected=$use_current_levels]-->
        </td>
      </tr>
	  <tr>
        <td class="mbground hcolor">Display Optimal</td>
        <td>
		<!--[html_options name='display_optimal' options=$disopt  selected=$display_optimal]-->
        </td>
      </tr>
 <!-- Hard Disabled in the PHP Code    <tr>
	<!--[if (in_array('1', $access)) || (in_array('5', $access)) || (in_array('6', $access))]-->
        <td class="mbground hcolor">Use Corporate hangar level</td>
        <td>
          <select name="use_hanger_levels">
            <option value="1">Yes</option>
            <option value="0" selected="selected">No</option>
          </select>
        </td>
	<!--[else]-->
	  <input type="hidden" name="use_hanger_levels" value="0" />
	<!--[/if]-->
      </tr> -->
      <tr>
        <td class="mbground hcolor">Ship Cargo Capacity (m3)</td>
        <td><input type="text" name="size" size="10" value="<!--[$cargosize]-->" /> m3</td>
      </tr>
      <tr>
        <td colspan="2" class="txtcenter"><input type="submit" name="action" value="Refill POS" /></td>
      </tr>
    </table>
  </div>
  </form>
<!--[if $fuel]-->
  <div>
    <table class="mcenter tracktable txtleft" style="margin-top:30px;width:640px;font-size: 12px;border-collapse:collapse;">
      <tr class="mbground">
        <td class="hcolor">Fuel</td>
        <td class="hcolor">Total Required</td>
        <td class="hcolor">You need</td>
        <td class="hcolor">Volume (m3)</td>
		<!--[if $display_optimal == 1]-->
		<td class="hcolor">Optimal Total</td>
		<td class="hcolor">Optimal Need</td>
		<td class="hcolor">Optimal m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Enriched Uranium</td>
        <!--[math equation="x*y*24" x=$fuel.required_uranium y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_uranium]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_uranium_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_uranium]--></td>
        <td><!--[formatnumber value=$optimalDiff.uranium]--></td>
        <td><!--[formatnumber value=$optimalDiff.uranium_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Oxygen</td>
        <!--[math equation="x*y*24" x=$fuel.required_oxygen y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_oxygen]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_oxygen_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_oxygen]--></td>
        <td><!--[formatnumber value=$optimalDiff.oxygen]--></td>
        <td><!--[formatnumber value=$optimalDiff.oxygen_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Mechanical Parts</td>
        <!--[math equation="x*y*24" x=$fuel.required_mechanical_parts y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_mechanical_parts]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_mechanical_parts_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_mechanical_parts]--></td>
        <td><!--[formatnumber value=$optimalDiff.mechanical_parts]--></td>
        <td><!--[formatnumber value=$optimalDiff.mechanical_parts_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Coolant</td>
        <!--[math equation="x*y*24" x=$fuel.required_coolant y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_coolant]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_coolant_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_coolant]--></td>
        <td><!--[formatnumber value=$optimalDiff.coolant]--></td>
        <td><!--[formatnumber value=$optimalDiff.coolant_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Robotics</td>
        <!--[math equation="x*y*24" x=$fuel.required_robotics y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_robotics]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_robotics_size]--></td>
		<!--[if $display_optimal == 1]-->
        <td><!--[formatnumber value=$optimal.optimum_robotics]--></td>
        <td><!--[formatnumber value=$optimalDiff.robotics]--></td>
        <td><!--[formatnumber value=$optimalDiff.robotics_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Isotopes (<!--[$race_isotope]-->)</td>
        <!--[math equation="x*y*24" x=$fuel.required_isotope y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_isotopes]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_isotopes_size]--></td>
		<!--[if $display_optimal == 1]-->
        <td><!--[formatnumber value=$optimal.optimum_isotope]--></td>
        <td><!--[formatnumber value=$optimalDiff.isotopes]--></td>
        <td><!--[formatnumber value=$optimalDiff.isotopes_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Liquid Ozone</td>
        <!--[math equation="x*y*24" x=$fuel.required_ozone y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_ozone]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_ozone_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_ozone]--></td>
		<td><!--[formatnumber value=$optimalDiff.ozone]--></td>
		<td><!--[formatnumber value=$optimalDiff.ozone_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Heavy Water</td>
        <!--[math equation="x*y*24" x=$fuel.required_heavy_water y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_heavy_water]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_heavy_water_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_heavy_water]--></td>
		<td><!--[formatnumber value=$optimalDiff.heavy_water]--></td>
		<td><!--[formatnumber value=$optimalDiff.heavy_water_m3]--> m3</td>
		<!--[/if]-->
      </tr>
      <tr>
        <td>Total Size</td>
        <td class="txtcenter" colspan="3"><!--[formatnumber value=$fuel.total_size]-->m3</td>
		<!--[if $display_optimal == 1]-->
		<td class="txtcenter" colspan="3"><!--[$optimalDiff.totalDiff]-->m3</td>
		<!--[/if]-->
      </tr><!--[if $fuel.trips || $fuel.trips2]-->
      <tr>
		<td>Trips</td>
        <td class="txtcenter" colspan="3"><!--[$fuel.trips]--> hauling trips</td>
		<!--[if $display_optimal == 1]-->
		<td class="txtcenter" colspan="3"><!--[$fuel.trips2]--> hauling trips</td>
		<!--[/if]-->
      </tr><!--[/if]-->
    </table><br>
	<a class="link" href="viewpos.php?i=<!--[$pos_id]-->">View POS</a>
  </div>
<!--[/if]-->



<!--[include file='footer.tpl']-->
