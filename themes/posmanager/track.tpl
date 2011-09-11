<!--[include file='header.tpl']-->
  <table class="mcenter tracktable sortable" style="width:100%;" cellspacing="0">
  <tbody>
    <tr class="mbground">
      <!--[*<td>Parent Outpost</td>*]-->
	  <td class="hcolor">Status</td>
      <td class="hcolor">POS <a class="sort" href="track.php?sb=<!--[if $sb != 5]-->5<!--[else]-->17<!--[/if]-->" title="Sort by POS Type">Type</a> / <a class="sort" href="track.php?sb=<!--[if $sb != 9]-->9<!--[else]-->21<!--[/if]-->" title="Sort by POS Size">Size</a> / <a class="sort" href="track.php?sb=<!--[if $sb != 10]-->10<!--[else]-->22<!--[/if]-->" title="Sort by POS Race">Race</a></td>
	  <td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 4]-->4<!--[else]-->16<!--[/if]-->" title="Sort by Tower Name">Tower Name</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 2]-->2<!--[else]-->14<!--[/if]-->" title="Sort by Location">Location</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 3]-->3<!--[else]-->15<!--[/if]-->" title="Sort by Region">Region</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 11]-->11<!--[else]-->23<!--[/if]-->" title="Sort by Corp">Corp</a> / <a class="sort" href="track.php?sb=<!--[if $sb != 6]-->6<!--[else]-->18<!--[/if]-->" title="Sort by Fuel Tech 1 Name">Fuel Tech 1</a> / <a class="sort" href="track.php?sb=<!--[if $sb != 7]-->7<!--[else]-->19<!--[/if]-->" title="Sort by Fuel Tech 2 Name">Fuel Tech 2</a></td>
      <td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 12]-->12<!--[else]-->24<!--[/if]-->" title="Sort by Last Fueled">Last Fueled</a></td>
		<!--[if $st == 1]-->
			<td class="hcolor">Stront Status</td>
		<!--[else]-->
			<td class="hcolor"><a class="sort" href="track.php?sb=<!--[if $sb != 1]-->1<!--[else]-->13<!--[/if]-->" title="Sort by Status">Status</a></td>
		<!--[/if]-->
		<td class="hcolor">Action</td>
    </tr>
  <!--[foreach item='pos' from=$poses]-->
    <!--[assign var='pos_size' value=$pos.pos_size]-->
    <tr style="background-color:<!--[$pos.bgcolor]-->;">
       <!--[*<td>None</td>*]-->
      <td><!--[if $pos.pos_status_img]--><img src="themes/<!--[$config.theme]-->/images/<!--[$pos.pos_status_img]-->" alt="<!--[$pos.pos_status_img]-->" /><!--[else]-->&nbsp;<!--[/if]--></td>
      <td><!--[$arrposize.$pos_size]--> <!--[$pos.pos_race]--></td>
      <td><!--[$pos.towerName]--></td>
      <td><!--[$pos.MoonName]--></td>
      <td><!--[$pos.region]--></td>
      <td><a class="link" href="#"><!--[$pos.corp]--></a><br><!--[$pos.name|default:"-"]--> / <!--[$pos.backup|default:"-"]--></td>
      <td><!--[$pos.status]--></td>
	  <!--[if $st == 1]-->
	  <td style="color:<!--[$pos.textcolor]-->;"><!--[$pos.strontium]--> (<!--[daycalc hours=$pos.uptimecalc.strontium]-->)</td>
	  <!--[else]-->
      <td style="color:<!--[$pos.textcolor]-->;"><!--[$pos.online]--></td>
      <!--[/if]-->
	  <td>
      <a href="viewpos.php?i=<!--[$pos.pos_id]-->"><img src="images/icons/zoom.png" border="0" alt="View" title="View" /></a>
      <a href="fuel_calculator.php?pos_to_refuel=<!--[$pos.pos_id]-->&days=30"><img src="images/icons/cart_go.png" border="0" alt="fuel Bill Calculator" title="Fuel Bill Calculator" /></a>
	  
      <!--[if ((($pos.name == $name || $pos.backup == $name) || in_array('5', $access) || in_array('6', $access) || in_array('21', $access) || in_array('22', $access) && $pos.corp == $corp) || (in_array('51', $access) || in_array('52', $access) && $pos.corp != $corp))]-->
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
  Stront Timers: <a href="track.php?st=1" title="Show Stront Timers">Show</a> / <a href="track.php?st=2" title="Hide Stront Timers">Hide</a> <BR>
  Display: <a href="track.php?sd=10" title="10">10</a> | <a href="track.php?sd=15" title="15">15</a> | <a href="track.php?sd=30" title="30">30</a> | <a href="track.php?sd=50" title="50">50</a> | <a href="track.php?sd=75" title="75">75</a> |  <a href="track.php?sd=100" title="100">100</a><br>
  <BR>Pages: <!--[pager numitems=$pager.numitems limit=$pager.limit]-->
  <!--[if (in_array('83', $access)) || (in_array('5', $access)) || (in_array('6', $access))]--><div class="mcenter"><a class="link" href="addpos.php" title="Add a new Tower">Add a New Tower</a></div><!--[/if]-->
<!--[include file='footer.tpl']-->
