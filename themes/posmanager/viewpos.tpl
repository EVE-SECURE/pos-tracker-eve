<!--[include file='header.tpl']-->

  <!--[assign var='pos_size' value=$tower.pos_size]-->
  <!--[assign var='pos_race' value=$tower.pos_race]-->
  <table class="mcenter">
  <tbody>
    <tr>
      <td rowspan="15"><img src="images/structures/256_256/<!--[$tower.typeID]-->.png" alt="<!--[$tower.towerName]-->" /></td>
      <td class="txtleft mbground hcolor">Last Updated:</td>
      <td class="txtleft"><!--[$last_update]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Was updated:</td>
      <td class="txtleft"><!--[$hoursago]--> Hours Ago</td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Online Since</td>
      <td class="txtleft"><!--[$tower.onlineSince]--></td>
    </tr>
	<tr>
      <td class="txtleft mbground hcolor">Last Fueled:</td>
      <td class="txtleft"><!--[$tower.status]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Type:</td>
      <td class="txtleft"><!--[$arrposize[$tower.pos_size]]--> <!--[$arrporace[$tower.pos_race]]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Status:</td>
      <td class="txtleft"><!--[$towerstatus[$tower.pos_status]]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Location:</td>
      <td class="txtleft"><!--[$tower.moonName]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Tower Name:</td>
      <td class="txtleft"><!--[$tower.towerName]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Sovereignty:</td>
      <td class="txtleft"><!--[if $tower.sovereignty]-->Yes<!--[else]-->No<!--[/if]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Sovereignty Status:</td>
      <td class="txtleft"><!--[if $tower.sovfriendly]-->Friendly<!--[else]-->Hostile<!--[/if]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">CPU:</td>
      <!--[if $tower.current_cpu > $tower.total_cpu]-->
        <td class="txtleft"><!--[$tower.current_cpu]--> / <!--[$tower.total_cpu]--></td>
      <!--[else]-->
        <td class="txtleft"><!--[$tower.current_cpu]--> / <!--[$tower.total_cpu]--></td>
      <!--[/if]-->
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">PowerGrid:</td>
       <!--[if $tower.current_pg > $tower.total_pg]-->
        <td class="txtleft"><!--[$tower.current_pg]--> / <!--[$tower.total_pg]--></td>
      <!--[else]-->
        <td class="txtleft"><!--[$tower.current_pg]--> / <!--[$tower.total_pg]--></td>
      <!--[/if]-->
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Fuel Tech:</td>
      <td class="txtleft"><!--[$tower.owner_name]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Backup Fuel Tech:</td>
      <td class="txtleft"><!--[$tower.secondary_owner_name]--></td>
    </tr>
	<!--[if (in_array('5', $access) || in_array('6', $access))]-->
	<tr>
      <td class="txtleft mbground hcolor">Secretive:</td>
	  <td class="txtleft"><!--[if $tower.secret_pos]-->Yes<!--[else]-->No<!--[/if]--></td>
    </tr>
	<!--[/if]-->
  </tbody>
  </table>

  <hr />
  <!--[if ((($tower.owner_name == $name || $tower.secondary_owner_name == $name) || in_array('5', $access) || in_array('6', $access) || in_array('21', $access) || in_array('22', $access) && $tower.corp == $corp) || (in_array('51', $access) || in_array('52', $access) && $tower.corp != $corp))]-->
  
  <div style="width:100%;">
  <div style="width:100px;display: inline-block;">
  <form method="post" action="editpos.php">
    <input name="pos_id" value="<!--[$tower.pos_id]-->" type="hidden" />
    <input class="mButton" name="action" value="Edit" type="submit" />
  </form>
  </div>
  <div style="width:100px;display: inline-block;">
  <form method="post" action="editpos.php">
    <input name="pos_id" value="<!--[$tower.pos_id]-->" type="hidden" />
	<input name="refuelme" value="1" type="hidden" />
	<input name="fuelblockOP" value="<!--[$optimal.optimum_fuelblock]-->" type="hidden" />
	<input name="chartersOP" value="<!--[$optimal.optimum_charters]-->" type="hidden" />
	<input name="strontiumOP" value="<!--[$tower.avail_strontium]-->" type="hidden" />
    <input class="mButton" name="action" value="Refuel" type="submit" />
  </form>
  </div>
  </div>
  <!--[/if]-->
  <table class="mcenter tracktable" style="width:600px;font-size: 12px;">
  <!--[assign var='uptimecalc' value=$tower.uptimecalc]-->
  <tbody>
    <tr>
      <th>Fuel</th>
      <th>Required</th>
      <th>Available</th>
      <th>Online</th>
      <th>Optimal</th>
      <th colspan="2">Difference</th>
    </tr>
    <tr>
      <td><img style="vertical-align:middle;" src="images/icons/<!--[$tower.fuelblockID]-->.png" alt="Fuelblocks" /></td>
      <td class="mcolor"><!--[$tower.required_fuelblock]--></td>
      <td><!--[$tower.avail_fuelblock]--></td>
      <td><!--[daycalc hours=$uptimecalc.fuelblock]--></td>
      <td class="mcolor"><!--[$optimal.optimum_fuelblock]--></td>
      <td><!--[$optimalDiff.fuelblock]--></td>
      <td><!--[$optimalDiff.fuelblock_m3]--> m3</td>
    </tr>
<!--[if $tower.charters_needed]-->
	<tr>
      <td><img style="vertical-align:middle;" src="images/icons/24594.png" alt="Charters" /></td>
      <td class="mcolor"><!--[$tower.required_charters]--></td>
      <td><!--[$tower.avail_charters]--></td>
      <td><!--[daycalc hours=$uptimecalc.charters]--></td>
      <td class="mcolor"><!--[$optimal.optimum_charters]--></td>
	  <td><!--[$optimalDiff.charters]--></td>
      <td><!--[$optimalDiff.charters_m3]--> m3</td>
    </tr>
<!--[/if]-->
    <tr>
      <td><img style="vertical-align:middle;" src="images/icons/16275.png" alt="Strontium Calthrates" /></td>
      <td class="mcolor"><!--[$tower.required_strontium]--></td>
      <td><!--[$tower.avail_strontium]--></td>
      <td><!--[daycalc hours=$uptimecalc.strontium]--></td>
      <td class="mcolor"><!--[$optimal.optimum_strontium]--></td>
      <td><!--[$optimalDiff.strontium]--></td>
      <td><!--[$optimalDiff.strontium_m3]--> m3</td>
    </tr>
  </tbody>
  </table>
Total Difference: <!--[$optimalDiff.totalDiff]-->m3

  <!--[if $display_hangar]-->
  <!--[foreach item='hangar' from=$hangars]-->
  <table class="mcenter tracktable" style="width:600px;font-size: 12px;">
  <tbody>
    <tr>
      <th>Fuel</th>
      <th>Required</th>
      <th>Available</th>
      <!--<th>Online</th>-->
    </tr>
    <tr>
      <td>Enriched Uranium</td>
      <td class="mcolor"><!--[$tower.required_uranium]--></td>
      <td><!--[$hangar.uranium]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.uranium]--></td>-->
    </tr>
    <tr>
      <td>Oxygen</td>
      <td class="mcolor"><!--[$tower.required_oxygen]--></td>
      <td><!--[$hangar.oxygen]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.oxygen]--></td>-->
    </tr>
    <tr>
      <td>Mechanical Parts</td>
      <td class="mcolor"><!--[$tower.required_mechanical_parts]--></td>
      <td><!--[$hangar.mechanical_parts]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.mechanical_parts]--></td>-->
    </tr>
    <tr>
      <td>Coolant</td>
      <td class="mcolor"><!--[$tower.required_coolant]--></td>
      <td><!--[$hangar.coolant]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.coolant]--></td>-->
    </tr>
    <tr>
      <td>Robotics</td>
      <td class="mcolor"><!--[$tower.required_robotics]--></td>
      <td><!--[$hangar.robotics]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.robotics]--></td>-->
    </tr>
<!--[if $tower.charters_needed]-->
	<tr>
      <td>Charters</td>
      <td class="mcolor"><!--[$tower.required_charters]--></td>
      <td><!--[$hangar.charters]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.charters]--></td>-->
    </tr>
<!--[/if]-->
    <tr>
      <td>Isotopes</td>
      <td class="mcolor"><!--[$tower.required_isotope]--></td>
      <td><!--[$hangar.isotope]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.isotope]--></td>-->
    </tr>
    <tr>
      <td>Liquid Ozone</td>
      <td class="mcolor"><!--[$tower.required_ozone2]-->(<!--[$tower.required_ozone]-->)</td>
      <td><!--[$hangar.ozone]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.ozone]--></td>-->
    </tr>
    <tr>
      <td>Heavy Water</td>
      <td class="mcolor"><!--[$tower.required_heavy_water2]-->(<!--[$tower.required_heavy_water]-->)</td>
      <td><!--[$hangar.heavy_water]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.heavy_water]--></td>-->
    </tr>
    <tr>
      <td>Strontium Calthrates</td>
      <td class="mcolor"><!--[$tower.required_strontium]--></td>
      <td><!--[$hangar.strontium]--></td>
      <!--<td><!--[daycalc hours=$uptimecalc.strontium]--></td>-->
    </tr>
  </tbody>
  </table>
<!--[/foreach]-->
  <!--[/if]-->

  <!--[*section name=foo start=0 loop=$linecount step=1*]-->
  <!--[*$smarty.section.foo.index*]-->
  <!--[*/section*]-->
  <!--[*assign var='lines' value=$tower.lines*]-->

  <!--[* NEW VERSION TODO
  <!--[if $lines]-->
  <h3>Moon Mining Arrays</h3>
  <table class="mcenter tracktable" style="font-size: 12px; border:1px #fff solid;">
  <tbody>
    <tr>
      <!--[section name=foo start=0 loop=$linecount step=1]-->
      <!--[assign var='linekey' value=$smarty.section.foo.index]-->
      <td>
        <table class="mcenter tracktable" style="font-size: 12px;">
        <tbody>
        <tr>
          <th>Module</th>
          <th>Material</th>
        </tr>
        <!--[assign var='line' value=$lines[$linekey]]-->
        <!--[foreach item='module' from=$line name='myline']-->
        <tr>
          <td><!--[$module.name]--> (<!--[$module.mod_id]-->)</td>
          <td><!--[$module.material_name]--></td>
        </tr>
        <!--[if not $smarty.foreach.myline.last]-->
        <tr>
          <td colspan="2" style="border:0;font-weight:bold;">&darr;</td>
        </tr>
        <!--[/if]-->
        <!--[/foreach]-->
        </tbody>
        </table>
      </td>
      <!--[/section]-->
    </tr>
  </tbody>
  </table>
  <!--[/if]-->

  *]-->



  <!--[*
  <!--[if $lines]-->
  <!--[foreach item='line' from=$lines]-->
  <table class="mcenter mbground hcolor" style="font-size: 12px; border:1px #fff solid;">
  <tbody>
    <tr>
      <th>Module</th>
      <th>Material</th>
    </tr>
    <!--[foreach item='module' from=$line name='myline']-->
    <tr>
      <td><!--[$module.name]--> (<!--[$module.mod_id]-->)</td>
      <td><!--[$module.material_name]--></td>
    </tr>
    <!--[if not $smarty.foreach.myline.last]-->
    <tr>
      <td colspan="2" style="border:0;">&darr;</td>
    </tr>
    <!--[/if]-->
    <!--[/foreach]-->
  </tbody>
  </table>
  <br />
  <!--[/foreach]-->
  <!--[/if]-->
  *]-->


  <!--[assign var='silos' value=$tower.silos]-->
  <!--[if $silos]-->
  <h3>Silo Hanger Arrays</h3>
  <table class="mcenter mbground hcolor" style="width:800px;font-size: 12px;">
  <tbody>
    <tr>
      <th>Silo</th>
      <th>Material</th>
      <th>Input/Output</th>
      <th>Required/Produced</th>
      <th>Available</th>
      <th>Online</th>
      <th>FULL</th>
      <th>Connected to:</th>
      <th>Linked to:</th>
    </tr>
  <!--[foreach item='silo' key='siloid' from=$silos]-->
    <tr>
      <td>Silo <!--[$siloid]--></td>
      <td><!--[$silo.material_name]--></td>
      <td><!--[if $silo.direction eq 'Output']-->Receiver<!--[else]-->Provider<!--[/if]--></td>
      <td><!--[$silo.rate]--> <span class="mcolor">(<!--[$silo.material_volume]-->m3)</span></td>
	  <td><!--[$silo.correct_amount]--></td>
      <td><!--[if $silo.full]-->FULL<!--[elseif $silo.empty]-->EMPTY<!--[else]--><!--[daycalc hours=$silo.hourstofill]--><!--[/if]--></td>
      <td><!--[if $silo.full]-->YES<!--[else]-->No<!--[/if]--></td>
      <td><!--[$silo.structure_name]--> (<!--[$silo.structure_material_name]-->)</td>
      <td><!--[if $silo.silo_link]-->Silo <!--[$silo.silo_link]--><!--[/if]--></td>
    </tr>
  <!--[/foreach]-->
  </tbody>
  </table>
  <!--[/if]-->

  <!--[assign var='mods' value=$tower.mods]-->
  <!--[if $mods]-->
  <h3>Modules</h3>
  <form method="post" action="fitexporter.xml.php"><input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->">Export Style: <Select name="xmlstyle"><option value="tracker">POS-Tracker Fitting</option><option value="mypos">MyPOS Fitting</option></select> <input class="mButton" type="submit" name="action" value="Export Structures"></form></p><br>

  <table class="mcenter tracktable" style="width:600px;font-size: 12px;">
  <tbody>
    <tr>
      <th>Module</th>
      <th>Name</th>
      <th>CPU</th>
      <th>PG</th>
      <th>Status</th>
    </tr>
    <!--[foreach item='mod' from=$mods]-->
    <tr>
      <td class="txtcenter" style="width:64px;"><!--[*$mod.mod_id*]--><img src="images/structures/64_64/<!--[$mod.type_id]-->.png" alt="<!--[$mod.name]-->" /></td>
      <td><!--[$mod.name]--></td>
      <td><!--[$mod.cpu]--></td>
      <td><!--[$mod.pg]--></td>
      <td><!--[if $mod.online]-->Online<!--[else]-->Anchored<!--[/if]--></td>
    </tr>
    <!--[/foreach]-->
  </tbody>
  </table>
  <!--[/if]-->

<!--[include file='footer.tpl']-->
