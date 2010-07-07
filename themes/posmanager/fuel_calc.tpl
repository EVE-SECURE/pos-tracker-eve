<!--[* $Id: fuel_calc.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h3 class="pageTitle">Fuel Calculator</h4>
  <form method="post" action="fuel_calculator.php">
  <div>
    <table class="fuelCalc" style="font-size: 12px;border-collapse:collapse;">
      <tr>
        <td class="trackheader" style="color:#CCCCCC;">POS To Refuel</td>
        <td><!--[html_options options=$opttowers name='pos_to_refuel' selected=$pos_to_refuel]--></td>
      </tr>
      <tr>
        <td class="trackheader" style="color:#CCCCCC;">X Days Y hour(s) worth of fuel</td>
        <td><input type="text" name="days" size="2" value="<!--[$days_to_refuel|default:"30"]-->" /> days <input type="text" name="hours" size="2" value="<!--[$hours]-->" /> hours</td>
      </tr>
      <tr>
        <td class="trackheader" style="color:#CCCCCC;">Use Current Level</td>
        <td>
          <select name="use_current_levels">
            <option value="1" selected="selected">Yes</option>
            <option value="0">No</option>
          </select>
        </td>
      </tr>
 <!-- Hard Disabled in the PHP Code    <tr>
	<!--[if $access > 2]-->
        <td class="trackheader" style="color:#CCCCCC;">Use Corporate hangar level</td>
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
        <td class="trackheader" style="color:#CCCCCC;">Ship Cargo Capacity (m3)</td>
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
    <table class="mcenter tracktable txtleft" style="margin-top:30px;width:460px;font-size: 12px;border-collapse:collapse;">
      <tr class="trackheader">
        <td>Fuel</td>
        <td>Total Required</td>
        <td>You need</td>
        <td>Volume (m3)</td>
      </tr>
      <tr>
        <td>Enriched Uranium</td>
        <!--[math equation="x*y*24" x=$fuel.required_uranium y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_uranium]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_uranium_size]--></td>
      </tr>
      <tr>
        <td>Oxygen</td>
        <!--[math equation="x*y*24" x=$fuel.required_oxygen y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_oxygen]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_oxygen_size]--></td>
      </tr>
      <tr>
        <td>Mechanical Parts</td>
        <!--[math equation="x*y*24" x=$fuel.required_mechanical_parts y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_mechanical_parts]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_mechanical_parts_size]--></td>
      </tr>
      <tr>
        <td>Coolant</td>
        <!--[math equation="x*y*24" x=$fuel.required_coolant y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_coolant]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_coolant_size]--></td>
      </tr>
      <tr>
        <td>Robotics</td>
        <!--[math equation="x*y*24" x=$fuel.required_robotics y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_robotics]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_robotics_size]--></td>
      </tr>
      <tr>
        <td>Isotopes</td>
        <!--[math equation="x*y*24" x=$fuel.required_isotope y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_isotopes]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_isotopes_size]--></td>
      </tr>
      <tr>
        <td>Liquid Ozone</td>
        <!--[math equation="x*y*24" x=$fuel.required_ozone y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_ozone]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_ozone_size]--></td>
      </tr>
      <tr>
        <td>Heavy Water</td>
        <!--[math equation="x*y*24" x=$fuel.required_heavy_water y=$days_to_refuel assign='total_required']-->
        <td style="color:#1B3169;"><!--[formatnumber value=$total_required]--></td>
        <td><!--[formatnumber value=$fuel.needed_heavy_water]--></td>
        <td style="color:#1B3169;"><!--[formatnumber value=$fuel.needed_heavy_water_size]--></td>
      </tr>
      <tr>
        <td>Total Size</td>
        <td class="txtcenter" colspan="3"><!--[formatnumber value=$fuel.total_size]-->m3</td>
      </tr><!--[if $fuel.trips]-->
      <tr>
        <td class="txtright" colspan="4"><!--[$fuel.trips]--> hauling trips</td>
      </tr><!--[/if]-->
    </table>
  </div>
<!--[/if]-->



<!--[include file='footer.tpl']-->
