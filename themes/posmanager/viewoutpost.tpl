<!--[* $Id: viewoutpost.tpl 231 2009-03-12 17:49:21Z stephenmg $ *]-->
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

<form method="post" action="editoutpost.php">
<input type="hidden" name="i" value="<!--[$outpost.outpost_id]-->" />
<div class="txtleft"><input type="hidden" name="action" value="updateoutpost" />
<input type="submit" name="action" value='Edit Outpost' /></form>
</div>
<!--[assign var='uptimecalc' value=$outpost.uptimecalc]-->
<table border="1" cellspacing="0" cellpadding="5" width="600">
<tr>
<th>Fuel</th>
<th>Required</th>
<th>Available</th>
<th>Online</th>
</tr>
<tr>
<td>Enriched Uranium</td>
<td><!--[$outpost_req.uranium]--></td>
<td><!--[$outpost.uranium]--></td>
<td><!--[daycalc hours=$uptimecalc.uranium]--></td>
</tr>
<tr>
<td>Oxygen</td>
<td><!--[$outpost_req.oxygen]--></td>
<td><!--[$outpost.oxygen]--></td>
<td><!--[daycalc hours=$uptimecalc.oxygen]--></td>
</tr>
<tr>
<td>Mechanical Parts</td>
<td><!--[$outpost_req.mechanical_parts]--></td>
<td><!--[$outpost.mechanical_parts]--></td>
<td><!--[daycalc hours=$uptimecalc.mechanical_parts]--></td>
</tr>
<tr>
<td>Coolant</td>
<td><!--[$outpost_req.coolant]--></td>
<td><!--[$outpost.coolant]--></td>
<td><!--[daycalc hours=$uptimecalc.coolant]--></td>
</tr>
<tr>
<td>Robotics</td>
<td><!--[$outpost_req.robotics]--></td>
<td><!--[$outpost.robotics]--></td>
<td><!--[daycalc hours=$uptimecalc.robotics]--></td>
</tr>
<tr>
<td>Helium Isotopes</td>
<td><!--[$outpost_req.heisotope]--></td>
<td><!--[$outpost.heisotope]--></td>
<td><!--[daycalc hours=$uptimecalc.heisotope]--></td>
</tr>
<tr>
<td>Hydrogen Isotopes</td>
<td><!--[$outpost_req.hyisotope]--></td>
<td><!--[$outpost.hyisotope]--></td>
<td><!--[daycalc hours=$uptimecalc.hyisotope]--></td>
</tr>
<tr>
<td>Oxygen Isotopes</td>
<td><!--[$outpost_req.oxisotope]--></td>
<td><!--[$outpost.oxisotope]--></td>
<td><!--[daycalc hours=$uptimecalc.oxisotope]--></td>
</tr>
<tr>
<td>Nitrogen Isotopes</td>
<td><!--[$outpost_req.niisotope]--></td>
<td><!--[$outpost.niisotope]--></td>
<td><!--[daycalc hours=$uptimecalc.niisotope]--></td>
</tr>
<tr>
<td>Liquid Ozone</td>
<td><!--[$uptimecalc.total_needed_ozone]-->(<!--[$uptimecalc.required_ozone]-->)</td>
<td><!--[$outpost.ozone]--></td>
<td><!--[daycalc hours=$uptimecalc.ozone]--></td>
</tr>
<tr>
<td>Heavy Water</td>
<td><!--[$uptimecalc.total_needed_heavy_water]-->(<!--[$uptimecalc.required_heavy_water]-->)</td>
<td><!--[$outpost.heavy_water]--></td>
<td><!--[daycalc hours=$uptimecalc.heavy_water]--></td>
</tr>
<tr>
<td>Strontium Calthrates</td>
<td><!--[$outpost_req.strontium]--></td>
<td><!--[$outpost.strontium]--></td>
<td><!--[daycalc hours=$uptimecalc.strontium]--></td>
</tr>
</table>
<br />
<!--[if $towers]-->
<div class="txtleft">Towers Being tracked:</div>
<!--[foreach item='tower' from=$towers]-->
<div class="txtleft"><!--[$tower.typeName]--> @ <!--[$tower.moonName]--></div>
<!--[/foreach]-->
<!--[else]-->
<div class="txtleft">No Towers are being tracked!</div>
<!--[/if]-->
<!--[include file='footer.tpl']-->