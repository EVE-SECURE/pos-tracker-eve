<!--[include file='header.tpl']-->

  <form method="post" action="track.php">
  <!--[html_options options=$sortlist name='sortlist' selected=$sb]-->
  <input type="submit" name="action" value="Sort Towers" />
  <!--[html_options options=$pagernumlist name='pagernumsel' selected=$pager.limit]-->
  <input type="submit" name="action" value="Display" />
  <!-- $st = $_POST['st']; -->
  <!--[if $st == 1]-->
  <input type="submit" name="action" value="Hide Stront Timers" />
  <!--[else]-->
  <input type="submit" name="action" value="Show Stront Timers" />
  <!--[/if]-->
  </form>
  <table class="mcenter tracktable" style="width:100%;" cellspacing="0">
  <tbody>
    <tr class="mbground">
      <!--[*<td>Parent Outpost</td>*]-->
      <td class="hcolor">Status</td>
      <td class="hcolor">POS Type</td>
      <td class="hcolor">Tower Name</td>
      <td class="hcolor">Location</td>
      <td class="hcolor">Region</td>
      <td class="hcolor">Owner</td>
      <td class="hcolor">Last Update</td>
	  <!--[if $st == 1]-->
	  <td class="hcolor">Stront Status</td>
	  <!--[else]-->
      <td class="hcolor">Status</td>
      <!--[/if]-->
	  <td class="hcolor">Action</td>
    </tr>

  <!--[foreach item='pos' from=$poses]-->
    <!--[assign var='pos_size' value=$pos.pos_size]-->
    <!--[assign var='pos_race' value=$pos.pos_race]-->
    <tr style="background-color:<!--[$pos.bgcolor]-->;">
       <!--[*<td>None</td>*]-->
      <td><!--[if $pos.pos_status_img]--><img src="themes/<!--[$config.theme]-->/images/<!--[$pos.pos_status_img]-->" alt="<!--[$pos.pos_status_img]-->" /><!--[else]-->&nbsp;<!--[/if]--></td>
      <td><!--[$arrposize.$pos_size]--> <!--[$arrporace.$pos_race]--></td>
      <td><!--[$pos.towerName]--></td>
      <td><a class="link" href="http://evemaps.dotlan.net/system/<!--[$pos.MoonName|regex_replace:"/ [XIV]+ - Moon.*/":""]-->/moons" target="_blank"><!--[$pos.MoonName]--></td>
      <td><a class="link" href="http://evemaps.dotlan.net/region/<!--[$pos.region|regex_replace:"/[^'a-z0-9-\.:,]/i":"_"]-->/moons" target="_blank"><!--[$pos.region]--></a></td>
      <td><a class="link" href="http://evemaps.dotlan.net/corp/<!--[$pos.corp|regex_replace:"/[^'a-z0-9-\.:,]/i":"_"]-->" target="_blank"><!--[$pos.corp]--></a><br><!--[$pos.name|default:"-"]--> / <!--[$pos.backup|default:"-"]--></td>
      <td><!--[$pos.last_update]--></td>
	  <!--[if $st == 1]-->
	  <td style="color:<!--[$pos.textcolor]-->;"><!--[$pos.strontium]--> (<!--[daycalc hours=$pos.uptimecalc.strontium]-->)</td>
	  <!--[else]-->
      <td style="color:<!--[$pos.textcolor]-->;"><!--[$pos.online]--></td>
      <!--[/if]-->
	  <td>
      <a href="viewpos.php?i=<!--[$pos.pos_id]-->"><img src="images/icons/zoom.png" border="0" alt="View" title="View" /></a>
      <a href="fuel_calculator.php?pos_to_refuel=<!--[$pos.pos_id]-->&days=30"><img src="images/icons/cart_go.png" border="0" alt="fuel Bill Calculator" title="Fuel Bill Calculator" /></a>
	  
      <!--[if (($pos.name == $name || $pos.backup == $name) || in_array('5', $access) || in_array('6', $access) || (in_array('21', $access) &&  $pos.corp == $corp) || (in_array('51', $access) &&  $pos.corp != $corp))]-->
      <a href="editpos.php?i=<!--[$pos.pos_id]-->"><img src="images/icons/pencil.png" border="0" alt="Edit" title="Edit" /></a>
	  <!--[/if]-->
	  
	  <!--[if (in_array('83', $access) && ($pos.name == $name || $pos.backup == $name)) || (in_array('5', $access)) || in_array('6', $access)]-->
      <a href="deletepos.php?i=<!--[$pos.pos_id]-->"><img src="images/icons/delete.png" border="0" alt="Delete POS" title="Delete" /></a>
      <!--[/if]-->
	  
      </td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>
  <!--[pager numitems=$pager.numitems limit=$pager.limit]-->
  <!--[if (in_array('83', $access)) || (in_array('5', $access)) || (in_array('6', $access))]--><div class="mcenter"><a class="link" href="addpos.php" title="Add a new Tower">Add a New Tower</a></div><!--[/if]-->
<!--[include file='footer.tpl']-->
