<!--[include file='header.tpl']-->

<div>
  <a href="viewpos.php?i=<!--[$tower.pos_id]-->" title="Back">Back</a>
  <form method="post" action="editpos.php">
  <div>
    <input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
  </div>
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
      <td class="txtleft mbground hcolor">Last Fueled:</td>
      <td class="txtleft"><!--[$tower.status]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">Type:</td>
      <td class="txtleft"><!--[$arrposize[$tower.pos_size]]--> <!--[$arrporace[$tower.pos_race]]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">Status:</td>
      <td class="txtleft">
        <!--[html_options options=$towerstatus name='newstatus' selected=$tower.pos_status]-->
      </td>
    </tr>
  <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">Outpost:</td>
      <td class="txtleft">
	<!--[if $access >= 2 ]-->
	        <!--[html_options options=$outpostlist name='outpostlist' selected=$tower.outpost_id]-->
	<!--[else]-->
		<!--[$outpostlist[$tower.outpost_id]]-->
	<!--[/if]-->
      </td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">Location:</td>
      <td class="txtleft"><!--[$tower.moonName]--></td>
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">Tower Name:</td>
      <td class="txtleft">
	<!--[if (in_array('1', $access) || in_array('5', $access) || in_array('6', $access)) ]-->
        	<input name="new_tower_name" type="text" value="<!--[$tower.towerName]-->" />
	<!--[else]-->
		<!--[$tower.towerName]-->
	<!--[/if]-->
      </td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Sovereignty:</td>
      <td class="txtleft"><!--[if $tower.sovereignty]-->Yes<!--[else]-->No<!--[/if]--></td>
    </tr>
    <tr>
      <td class="txtleft mbground hcolor">Sovereignty Status:</td>
      <td class="txtleft"><!--[if $tower.sovfriendly]-->Friendly<!--[else]-->Hostile<!--[/if]--></td>
    </tr>

<!--[if $mods]-->
      <td class="txtleft mbground hcolor">CPU:</td>
      <!--[if $tower.current_cpu > $tower.total_cpu]-->
        <td class="txtleft"><!--[$tower.current_cpu]--> / <!--[$tower.total_cpu]--></td>
      <!--[else]-->
        <td class="txtleft"><!--[$tower.current_cpu]--> / <!--[$tower.total_cpu]--></td>
      <!--[/if]-->
    </tr>
    <tr>
      <!--<td></td>-->
      <td class="txtleft mbground hcolor">PowerGrid:</td>
       <!--[if $tower.current_pg > $tower.total_pg]-->
        <td class="txtleft"><!--[$tower.current_pg]--> / <!--[$tower.total_pg]--></td>
      <!--[else]-->
        <td class="txtleft"><!--[$tower.current_pg]--> / <!--[$tower.total_pg]--></td>
      <!--[/if]-->
<!--[else]-->
<td class="txtleft mbground hcolor">CPU:</td>
<td class="txtleft"><input name="new_cpu" type="text" value="<!--[$tower.current_cpu]-->" /> /<!--[$tower.total_cpu]--></td></tr><tr>
<td class="txtleft mbground hcolor">PowerGrid:</td>
<td class="txtleft"><input name="new_pg" type="text" value="<!--[$tower.current_pg]-->" /> /<!--[$tower.total_pg]--></td>
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
	<!--[if (in_array('5', $access) || in_array('6', $access))]-->
	<tr>
	  <input type="hidden" name="new_secret" value="<!--[$tower.secret_pos]-->" />
      <td colspan="3" class="tracktable txtcenter"><input class="mButton" type="submit" name="action" value="Change POS Secretive Status" /></td>
    </tr>
	<!--[/if]-->
    <tr>
      <td colspan="3" class="tracktable txtcenter"><input class="mButton" type="submit" name="action" value="Change Tower Information" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<hr />
<div>
<form method="post" action="editpos.php">
<input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
<!--[html_options options=$users name='newowner' selected=$tower.owner_id]-->
<input class="mButton" type="submit" name="action" value="Assign As Fuel Tech" />
<input class="mButton" type="submit" name="action" value="Assign As Backup Fuel Tech" />
</div>
<hr />
<div>
  <form method="post" action="editpos.php">
  <div>
    <input name="i" value="<!--[$tower.pos_id]-->" type="hidden" />
  </div>
  <table class="mcenter tracktable" style="width:650px; padding:5px;" cellspacing="0">
  <tbody>
    <tr>
      <th>Fuel</th>
      <th>Currently</th>
      <th>New Values</th>
      <th class="mcolor">Optimum</th>
      <th colspan="2">Difference</th>
    </tr>
    <tr>
      <td><img style="vertical-align:middle;" src="images/icons/<!--[$tower.fuelblockID]-->.png" alt="Fuelblocks" /></td>
      <td><!--[$tower.avail_fuelblock]--></td>
      <td><input name="fuelblock" value="<!--[$tower.avail_fuelblock]-->" size="10" type="text" /></td>
      <td class="mcolor"><!--[$optimal.optimum_fuelblock]--></td>
      <td class="txtright"><!--[$optimalDiff.fuelblock]--></td>
      <td class="txtright">(<!--[$optimalDiff.fuelblock_m3]--> m3)</td>
    </tr>
<!--[if $tower.charters_needed]-->
  <tr>
      <td><img style="vertical-align:middle;" src="images/icons/24594.png" alt="Charters" /></td>
      <td><!--[$tower.avail_charters]--></td>
      <td><input name="charters" value="<!--[$tower.avail_charters]-->" size="10" type="text" /></td>
      <td class="mcolor"><!--[$optimal.optimum_charters]--></td>
      <td class="txtright"><!--[$optimalDiff.charters]--></td>
      <td class="txtright">(<!--[$optimalDiff.charters_m3]--> m3)</td>
    </tr>
<!--[/if]-->
    <tr>
      <td><img style="vertical-align:middle;" src="images/icons/16275.png" alt="Strontium Calthrates" /></td>
      <td><!--[$tower.avail_strontium]--></td>
      <td><input name="strontium" value="<!--[$tower.avail_strontium]-->" size="10" type="text" /></td>
      <td class="mcolor"><!--[$optimal.optimum_strontium]--></td>
      <td class="txtright"><!--[$optimalDiff.strontium]--></td>
      <td class="txtright">(<!--[$optimalDiff.strontium_m3]--> m3)</td>
    </tr>
    <tr>
      <td colspan="6" class="txtcenter" style="padding:10px;"><input class="mButton" name="action" value="Update Fuel" type="submit" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[*assign var='hangars' value=$tower.hangars*]-->
<!--[*if $hangars]-->
<hr />
<div>
  <h3>Hangars</h3>
  <!--[foreach item='hangar' key='hangarid' from=$hangars]-->
  <h4>Hangar <!--[$hangarid]--></h4>
  <table class="mcenter tracktable" style="width:650px; padding:5px;" cellspacing="0">
  <thead>
    <tr>
      <th>Fuel</th>
      <th>Previously</th>
      <th>New Values</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Enriched Uranium</td>
      <td><!--[$hangar.uranium]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Oxygen</td>
      <td><!--[$hangar.oxygen]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Mechanical Parts</td>
      <td><!--[$hangar.mechanical_parts]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Coolant</td>
      <td><!--[$hangar.coolant]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Robotics</td>
      <td><!--[$hangar.robotics]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Isotopes</td>
      <td><!--[$hangar.isotope]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Liquid Ozone</td>
      <td><!--[$hangar.ozone]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Heavy Water</td>
      <td><!--[$hangar.heavy_water]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td>Strontium Calthrates</td>
      <td><!--[$hangar.strontium]--></td>
      <td><input name="ozone" value="" size="10" type="text" /></td>
    </tr>
    <tr>
      <td colspan="3" class="txtcenter"><input class="mButton" type="submit" value="Update Hangar Stock" /></td>
    </tr>
  </tbody>
  </table>
  <!--[/foreach]-->
</div>
<!--[/if*]-->

<!--[assign var='silos'  value=$tower.silos]-->
<!--[assign var='miners' value=$tower.miners]-->
<!--[if $miners]-->
<hr />
<div>
  <h3>Harvesters/Reactors Arrays</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updateminers" />
  </div>
  <table class="mcenter tracktable" style="font-size: 12px;">
  <tbody>
    <tr>
      <th>Module</th>
      <th>Material</th>
    </tr>
  <!--[foreach item='miner' key='minerid' from=$miners]-->
    <tr>
      <td><!--[$miner.name]--> <!--[$miner.structure_id]--></td>
      <td><select name="material[<!--[$miner.structure_id]-->]"><!--[html_options options=$optmaterials selected=$miner.material_id]--></select><!--[*$miner.material_name*]--></td>
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="Update Chain Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->
<!--[if $silos]-->
<hr />
<div>
  <h3>Silo Arrays</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updatesilos" />
  </div>
  <table class="mcenter tracktable" style="font-size: 12px;">
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
      <td>Silo <!--[$silo.silo_id]--></td>
      <td><select name="material[<!--[$silo.silo_id]-->]"><!--[html_options options=$optmaterials selected=$silo.material_id]--></select><!--[*$silo.material_name*]--></td>
      <!--[*<td><!--[if $silo.direction eq 'Output']-->Receiver<!--[else]-->Provider<!--[/if]--></td>*]-->
      <td><select name="direction[<!--[$silo.silo_id]-->]"><!--[html_options options=$optdirections selected=$silo.direction]--></select></td>
      <td><!--[$silo.rate]--> <span style="color:#aaaaaa;">(<!--[$silo.material_volume]-->m3)</span></td>
      <td><input type="text" name="new_amount[<!--[$silo.silo_id]-->]" value="<!--[$silo.correct_amount]-->" /></td>
      <td><!--[if $silo.full]-->FULL<!--[elseif $silo.empty]-->EMPTY<!--[else]--><!--[daycalc hours=$silo.hourstofill]--><!--[/if]--></td>
      <td><!--[if $silo.full]-->YES<!--[else]-->No<!--[/if]--></td>
      <td><select name="connection[<!--[$silo.silo_id]-->]"><!--[html_options options=$optminers selected=$silo.connection_id]--></select></td>
      <td><input size="6" type="text" name="links[<!--[$silo.silo_id]-->]" value="<!--[$silo.silo_link]-->" /></td>
      <!--[*<td><!--[$silo.structure_name]--> (<!--[$silo.structure_material_name]-->)</td>*]-->
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="9" class="txtcenter"><input class="mButton" type="submit" value="Update Silo Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->


<!--[assign var='mods' value=$tower.mods]-->
<div>
<!--[if (in_array('5', $access) || in_array('6', $access) || in_array('42', $access) || in_array('43', $access) || in_array('44', $access)) ]-->
<hr />
  <form method="post" action="addstructure.php">
  <div>
    <input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="struct_amount" value="1" />
    <input class="mButton" type="submit" name="action" value="Add Structures" />
  </form>
  <br /><br />
    <form method="post" action="importfit.php">
    <input type="hidden" name="pos_id" value="<!--[$tower.pos_id]-->" />
    <input class="mButton" type="submit" name="action" value="Import Structures" />
  </div>
  </form>
<!--[/if]-->

</div>
<!--[if $mods]-->
<hr />
<div>
  <h3>Modules</h3>
  <form method="post" action="editpos.php">
  <div>
    <input type="hidden" name="i"      value="<!--[$tower.pos_id]-->" />
    <input type="hidden" name="action" value="updatemods" />
  </div>
  <table class="mcenter tracktable" style="width:600px;font-size: 12px;border-collapse:collapse;">
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>CPU</th>
      <th>PG</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <!--[foreach item='mod' from=$mods]-->
    <!--[assign var='modid' value=$mod.mod_id]-->
    <tr>
      <td class="txtleft"><!--[$mod.mod_id]--></td>
      <td class="txtleft"><!--[$mod.name]--></td>
      <td><!--[$mod.cpu]--></td>
      <td><!--[$mod.pg]--></td>
      <td><!--[foreach item='modstate' key='modstateid' from=$arronline]--><label><input style="width: 1.5em; height: 1.5em;" name="mod[<!--[$modid]-->]" value="<!--[$modstateid]-->"<!--[if $mod.online eq $modstateid]--> checked="checked"<!--[/if]--> type="radio" /><!--[$modstate]--></label><!--[/foreach]--><!--[*html_checkboxes options=$arronline selected=$mod.online name="mod[$modid]"*]--></td>
    </tr>
    <!--[/foreach]-->
    <tr>
      <td colspan="5" class="txtcenter"><input class="mButton" type="submit" value="Update Module Info" /></td>
    </tr>
  </tbody>
  </table>
  </form>
</div>
<!--[/if]-->

<!--[include file='footer.tpl']-->
