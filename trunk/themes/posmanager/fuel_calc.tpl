<!--[include file='header.tpl']-->
  <form method="post" action="fuel_calculator.php">
  <div>
    <table class="mcenter tracktable" style="font-size: 12px;border-collapse:collapse;">
      <tr>
        <td class="mbground hcolor">POS To Refuel <!--[if $fuel]-->( <a class="sort" href="viewpos.php?i=<!--[$pos_id]-->">View POS</a> )<!--[/if]--></td>
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
	   <tr>
        <td class="mbground hcolor">Partial Fuelup</td>
        <td>
		<!--[html_options name='partial_fuelup' options=$partialopt  selected=$partial_fuelup]-->
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
        <td colspan="2" class="txtcenter"><input class="mButton" type="submit" name="action" value="Refill POS" /></td>
      </tr>
    </table>
  </div>
  </form>
<!--[if $fuel]-->
  <div>
    <table class="mcenter tracktable txtleft" style="margin-top:30px;width:800px;font-size: 12px;border-collapse:collapse;">
	<thead>
          <tr class="mbground">
		  <th class="mbground hcolor">Fuel</th>
          <th class="mbground hcolor">Total Required</th>
		  <th class="mbground hcolor">You need</th>
		  <th class="mbground hcolor">Volume (m3)</th>
		  <!--[if $display_optimal == 1]-->
		  <th class="mbground hcolor">Optimal Total</th>
		  <th class="mbground hcolor">Optimal Need</th>
		  <th class="mbground hcolor">Optimal (m3)</th>
		  <!--[if $partial_fuelup == 1]-->
		  <th class="mbground hcolor">Partial Total</th>
		  <!--[/if]-->
		  <!--[/if]-->
		  </tr>
	</thead>
	<tbody class="auser">
      <tr>
        <td>Fuelblock</td>
        <!--[math equation="x*y*24" x=$fuel.required_fuelblock y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_fuelblock]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_fuelblock_size]--></td>
		<!--[if $display_optimal == 1]-->
		<td><!--[formatnumber value=$optimal.optimum_fuelblock]--></td>
        <td><!--[formatnumber value=$optimalDiff.fuelblock]--></td>
        <td><!--[formatnumber value=$optimalDiff.fuelblock_m3]--> m3</td>
		<!--[if $partial_fuelup == 1]-->
		<td><!--[formatnumber value=$partial_optimal.optimum_fuelblock]--></td>
		<!--[/if]-->
		<!--[/if]-->
      </tr>
	  </tbody>
	  <!--[if $fuel.needed_charters]-->
	  <tbody class="auser">
	   <tr>
        <td>Charters</td>
        <!--[math equation="x*y*24" x=$fuel.required_charters y=$days_to_refuel assign='total_required']-->
        <td class="mcolor"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_charters]--></td>
        <td class="mcolor"><!--[formatnumber value=$fuel.needed_charter_size]--></td>
		<!--[if $display_optimal == 1]-->
        <td><!--[formatnumber value=$optimal.optimum_charters]--></td>
        <td><!--[formatnumber value=$optimalDiff.charters]--></td>
        <td><!--[formatnumber value=$optimalDiff.charters_m3]--> m3</td>
		<!--[if $partial_fuelup == 1]-->
		<td><!--[formatnumber value=$partial_optimal.optimum_charters]--></td>
		<!--[/if]-->
		<!--[/if]-->
      </tr>
	  </tbody>
	  <!--[/if]-->
      <tr>
        <td>Total Size</td>
        <td class="txtcenter" colspan="3"><!--[formatnumber value=$fuel.total_volume]-->m3</td>
		<!--[if $display_optimal == 1]-->
		<td class="txtcenter" colspan="3"><!--[formatnumber value=$optimalDiff.totalDiff]-->m3</td>
		<!--[if $partial_fuelup == 1]-->
		<td><!--[formatnumber value=$partial_optimal.total]--> m3</td>
		<!--[/if]-->
		<!--[/if]-->
      </tr><!--[if $fuel.trips || $fuel.trips2]-->
      <tr>
		<td>Trips</td>
        <td class="txtcenter" colspan="3"><!--[$fuel.trips]--> hauling trips</td>
		<!--[if $display_optimal == 1]-->
		<td class="txtcenter" colspan="3"><!--[$fuel.trips2]--> hauling trips</td>
		<!--[if $partial_fuelup == 1]-->
		<td>1 hauling trip</td>
		<!--[/if]-->
		<!--[/if]-->
      </tr>
	  <!--[/if]-->
	  <tr>
		<td>Total Hours</td>
        <td class="txtcenter" colspan="3"><!--[$days_to_refuel]-->d <!--[daycalc hours=$hours]--></td>
		<!--[if $display_optimal == 1]-->
		<td class="txtcenter" colspan="3"><!--[daycalc hours=$optimal.optimum_cycles]--></td>
		<!--[if $partial_fuelup == 1]-->
		<td><!--[daycalc hours=$partial_optimal.optimum_cycles]--></td>
		<!--[/if]-->
		<!--[/if]-->
      </tr>
    </table><br>
  </div>
<hr>
 <table class="txtleft" style="width:600px;font-size: 14px;">
  <tbody>
    <tr>
      <th>Max fuel on </th>
      <th><!--[$fuel.pos_size_name]--> <!--[$fuel.pos_race_name]--> at <!--[$fuel.locationName]--></th>
    </tr>
    <tr>
      <td>Fuelblock</td>
      <td class="mcolor"><!--[$optimalDiff.fuelblock]--></td>
    </tr>
<!--[if $fuel.needed_charters]-->
        <tr>
      <td>Charters</td>
      <td class="mcolor"><!--[$optimalDiff.charters]--></td>
    </tr>
<!--[/if]-->
    <tr>
      <th>Cargo needed:</td>
      <th class="mcolor"><!--[$optimalDiff.totalDiff]-->m3</td>
    </tr>
  </tbody>
  </table>
<!--[if $partial_fuelup == 1]-->
<hr>
 <table class="txtleft" style="width:600px;font-size: 14px;">
  <tbody>
    <tr>
      <th>Partial fuelup on </th>
      <th><!--[$fuel.pos_size_name]--> <!--[$fuel.pos_race_name]--> at <!--[$fuel.locationName]--></th>
    </tr>
    <tr>
      <td>Fuelblock</td>
      <td class="mcolor"><!--[$partial_optimal.optimum_fuelblock]--></td>
    </tr>
<!--[if $fuel.needed_charters]-->
        <tr>
      <td>Charters</td>
      <td class="mcolor"><!--[$partial_optimal.optimum_charters]--></td>
    </tr>
<!--[/if]-->
    <tr>
      <th>Cargo needed:</td>
      <th class="mcolor"><!--[$partial_optimal.total]-->m3</td>
    </tr>
	<tr>
      <th>Time gained:</td>
      <th class="mcolor"><!--[daycalc hours=$partial_optimal.optimum_cycles]--></td>
    </tr>
  </tbody>
  </table>
<!--[/if]-->
<!--[/if]-->


<!--[include file='footer.tpl']-->
