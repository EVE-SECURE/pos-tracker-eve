<!--[include file='header.tpl']-->

  <h3 class="pageTitle">Production Overview</h3>
  <form class="mcenter" method="post" action="production.php">
  <p class="mcenter">
    <!--[html_options name='filter_regionID' options=$optregions selected=$filter_regionID]-->
    <!--[html_options name='filter_systemID' options=$optsystems selected=$filter_systemID]-->
    <!--[html_options name='filter_pos_id'   options=$optposids  selected=$filter_pos_id]-->
    <input type="submit" name="submit" value="Filter" /> - <a class="link" href="production.php" title="Clear Filter">Clear Filter</a>
  </p>
  </form>
  <form style="margin: 0pt; padding: 0pt;" method="post" action="production.php">
  <table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
  <tbody>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Tower</td>
      <td class="txtcenter hcolor billheader">System</td>
      <td class="txtcenter hcolor billheader">Id</td>
      <td class="txtcenter hcolor billheader">Type</td>
      <td class="txtcenter hcolor billheader">&nbsp;M3&nbsp;</td>
      <td class="txtcenter hcolor billheader">New Amount</td>
      <td class="txtcenter hcolor billheader">Amount in Silo</td>
      <td class="txtcenter hcolor billheader">Amount in Silo (M3)</td>
      <td class="txtcenter hcolor billheader">Input/Output</td>
      <td class="txtcenter hcolor billheader">Time Until Full/Empty</td>
    </tr>

  <!--[assign var='systemback' value=$allsilos[0].systemID]-->
  <!--[foreach item='tower' from=$allsilos]-->
  <!--[if $tower.owner_id eq $userinfo.eve_id]-->
    <!--[assign var='bgcolor' value=$owner_bgcolor]-->
  <!--[elseif $tower.secondary_owner_id eq $userinfo.eve_id]-->
    <!--[assign var='bgcolor' value=$owner_bgcolor]-->
  <!--[else]-->
    <!--[assign var='bgcolor' value="#111111"]-->
  <!--[/if]-->

  <!--[if $systemback neq $tower.systemID]-->
    <!--[assign var='systemback' value=$tower.systemID]-->
  <!--[/if]-->
  <!--[foreach item='silo' from=$tower.silos]-->
    <tr>
	  <td><a class="link" href="viewpos.php?i=<!--[$tower.pos_id]-->" title="<!--[$tower.towerName]-->"><!--[$tower.towerName]--></a></td>
      <td><a class="link" href="viewpos.php?i=<!--[$tower.pos_id]-->" title="<!--[$tower.locationName]-->"><!--[$tower.locationName]--></a></td>
      <td><!--[$silo.silo_id]--></td>
      <td><!--[$silo.material_name]--></td>
      <td class="txtcenter">&nbsp;<!--[$silo.material_volume]-->&nbsp;</td>
      <td class="txtcenter"><div><input name="referer" value="production.php" type="hidden" /><input name="filter_systemID" value="<!--[$filter_regionID]-->" type="hidden" /><input name="filter_pos_id" value="<!--[$filter_pos_id]-->" type="hidden" /><input name="filter_systemID" value="<!--[$filter_systemID]-->" type="hidden" /><input name="structure_id_<!--[$silo.silo_id]-->" value="<!--[$silo.silo_id]-->" type="hidden" /><input size="7" name="new_amount_<!--[$silo.silo_id]-->" value="<!--[$silo.material_amount]-->" type="text" /></div></td>
      <td class="txtright" ><!--[formatnumber value=$silo.material_amount]-->&nbsp;&nbsp;</td>
      <!--[math equation="x*y" x=$silo.material_amount y=$silo.material_volume|default:0 assign='matvolume']-->
      <td class="txtright"><!--[formatnumber value=$matvolume]-->&nbsp;&nbsp;</td>
      <td class="txtcenter">&nbsp;<!--[$silo.direction]-->&nbsp;</td>
      <td class="txtcenter" style="border:1px <!--[if $silo.full or $silo.empty]-->red<!--[else]-->#aaaaaa<!--[/if]--> solid;"><!--[if $silo.full]-->FULL<!--[elseif $silo.empty]-->EMPTY<!--[else]--><!--[daycalc hours=$silo.hourstofill]--><!--[/if]--><!--[if $silo.silo_link]--> (Link: <!--[$silo.silo_link]-->)<!--[/if]--></td>
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="10"><hr></td>
    </tr>
  <!--[/foreach]-->
  </tbody>
  </table>
  <center><input name="action" value="Update Amount" class="mainoption" type="submit" /></center>
</form>

<!--[include file='footer.tpl']-->
