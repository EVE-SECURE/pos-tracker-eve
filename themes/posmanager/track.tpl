<!--[include file='header.tpl']-->

  <form method="post" action="track.php">
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
      <td class="hcolor">POS <a class="sort" href="track.php?sb=5" title="Sort by POS Type">Type</a> / <a class="sort" href="track.php?sb=9" title="Sort by POS Size">Size</a> / <a class="sort" href="track.php?sb=10" title="Sort by POS Race">Race</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=4" title="Sort by Tower Name">Tower Name</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=2" title="Sort by Location">Location</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=3" title="Sort by Region">Region</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=11" title="Sort by Corp">Corp</a> / <a class="sort" href="track.php?sb=6" title="Sort by Fuel Tech 1 Name">Fuel Tech 1</a> / <a class="sort" href="track.php?sb=7" title="Sort by Fuel Tech 2 Name">Fuel Tech 2</a></td>
      <td class="hcolor">Last Update</td>
	  <!--[if $st == 1]-->
	  <td class="hcolor">Stront Status</td>
	  <!--[else]-->
      <td class="hcolor"><a class="sort" href="track.php?sb=1" title="Sort by Status">Status</a></td>
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
      <td><!--[$pos.MoonName]--></td>
      <td><!--[$pos.region]--></td>
      <td><a class="link" href="#"><!--[$pos.corp]--></a><br><!--[$pos.name|default:"-"]--> / <!--[$pos.backup|default:"-"]--></td>
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
	  <a href="http://evemaps.dotlan.net/system/<!--[$pos.MoonName|regex_replace:"/ [XIV]+ - Moon.*/":""]-->/moons" target="_blank"><img src="images/icons/loc.png" border="0" alt="Moon Location" title="Location" /></a>
      </td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>
  <!--[pager numitems=$pager.numitems limit=$pager.limit]-->
  <!--[if (in_array('83', $access)) || (in_array('5', $access)) || (in_array('6', $access))]--><div class="mcenter"><a class="link" href="addpos.php" title="Add a new Tower">Add a New Tower</a></div><!--[/if]-->
<!--[include file='footer.tpl']-->
