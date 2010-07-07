<!--[* $Id: editoutpost.tpl 168 2008-09-20 07:24:02Z stephenmg $ *]-->
<!--[include file='header.tpl']-->
<table width='893' border='0'>
<tr>
<td width='120' height='15'>
<div align='left'>Last Updated:</div>
</td>
<td width='210'>
<div align='left'><!--[$outpost.lastupdate]--></div>
</td>
<td width='509'>
<div align='left'></div>
</td>
</tr>
<tr>
<td>
<div align='left'>Was updated:</div>
</td>
<td>
<div align='left'><!--[$outpost.hoursago]--> Hours Ago</div>
</td>
<td>
<div align='left'></div>
</td>
</tr>
<tr>
<td>
<div align='left'>Outpost Name:</div>
</td>
<td>
<div align='left'><!--[$outpost.outpost_name]--></div>
</td>
<td>
<div align='left'></div>
</td>
</tr>
<!-- <tr><td></td><div align='left'>System Name:</div><td><div align='left'>testing</div></td><td><div align='left'></div></td></tr> -->

</table>
<br />
<form method='post' action='editoutpost.php'><input type=
'hidden' name='id' value='1' /><input type="hidden" name=
"charters" value="0" />
<table border='1' cellspacing='0' cellpadding='5' width='600'>
<tr>
<th>Fuel in Outpost Hanger</th>
<th>Previously</th>
<th>New Values</th>
</tr>
<tr>
<td>Enriched Uranium</td>
<td><!--[$outpost.uranium]--></td>
<td><input type='text' name='uranium' size="10" /></td>
</tr>
<tr>
<td>Oxygen</td>
<td><!--[$outpost.oxygen]--></td>
<td><input type="text" name="oxygen" size="10" /></td>
</tr>
<tr>
<td>Mechanical Parts</td>
<td><!--[$outpost.mechanical_parts]--></td>
<td><input type="text" name="mechanical_parts" size=
"10" /></td>
</tr>
<tr>
<td>Coolant</td>
<td><!--[$outpost.coolant]--></td>
<td><input type="text" name="coolant" size="10" /></td>
</tr>
<tr>
<td>Robotics</td>
<td><!--[$outpost.robotics]--></td>
<td><input type="text" name="robotics" size="10" /></td>
</tr>
<tr>
<td>Helium Isotopes</td>
<td><!--[$outpost.heisotope]--></td>
<td><input type="text" name="heisotope" size="10" /></td>
</tr>
<tr>
<td>Hydrogen Isotopes</td>
<td><!--[$outpost.hyisotope]--></td>
<td><input type="text" name="hyisotope" size="10" /></td>
</tr>
<tr>
<td>Oxygen Isotopes</td>
<td><!--[$outpost.oxisotope]--></td>
<td><input type="text" name="oxisotope" size="10" /></td>
</tr>
<tr>
<td>Nitrogen Isotopes</td>
<td><!--[$outpost.niisotope]--></td>
<td><input type="text" name="niisotope" size="10" /></td>
</tr>
<tr>
<td>Liquid Ozone</td>
<td><!--[$outpost.ozone]--></td>
<td><input type="text" name="ozone" size="10" /></td>
</tr>
<tr>
<td>Heavy Water</td>
<td><!--[$outpost.heavy_water]--></td>
<td><input type="text" name="heavy_water" size="10" /></td>
</tr>
<tr>
<td>Strontium Calthrates</td>
<td><!--[$outpost.strontium]--></td>
<td><input type="text" name="strontium" size="10" /></td>
</tr>
</table>
<p>
<input type="hidden" name="i" value="<!--[$outpost.outpost_id]-->" />
<input type="hidden" name="action" value="updateoutpost" />
<input type="submit" name="action" value="Update Outpost Hangar" />
</p>
</form>
<!--[include file='footer.tpl']-->