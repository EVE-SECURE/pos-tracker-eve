<!--[* $Id: production.tpl 223 2008-12-26 17:40:57Z eveoneway $ *]-->
<!--[include file='header.tpl']-->

  <h3 class="pageTitle">Production Overview</h3>
  <form style="text-align: center;" method="post" action="production.php">
  <p style="text-align:center;">
    <!--[html_options name='filter_regionID' options=$optregions selected=$filter_regionID]-->
    <!--[if $access > 2 ]--><!--[html_options name='filter_systemID' options=$optsystems selected=$filter_systemID]--><!--[/if]-->
    <!--[html_options name='filter_pos_id'   options=$optposids  selected=$filter_pos_id]-->
    <input type="submit" name="submit" value="Filter" /> - <a href="production.php" title="Clear Filter">Clear Filter</a>
  </p>
  </form>
  <table class="mcenter" style="padding:0; width:70%; border:1px #336699 solid; font-family: Arial,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: normal; font-size-adjust: none; font-stretch: normal;" cellspacing="1">
  <tbody>
    <tr class="arialwhitebold12" style="background-color:#336699;">
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">System</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Id</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Type</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">&nbsp;M3&nbsp;</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Starting Amount</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Amount in Silo</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Amount in Silo (M3)</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Input/Output</td>
      <td class="txtcenter arialwhite12 billheader" style="border:1px #336699 solid;">Time Until Full/Empty</td>
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
    <tr style="border:1px #aaaaaa solid;background-color:#F2EFE9;">
      <td><a style="color:#1B3169;" href="viewpos.php?i=<!--[$tower.pos_id]-->" title="<!--[$tower.locationName]-->"><!--[$tower.locationName]--></a></td>
      <td><!--[$silo.silo_id]--></td>
      <td><!--[$silo.material_name]--></td>
      <td class="txtcenter">&nbsp;<!--[$silo.material_volume]-->&nbsp;</td>
      <td class="txtcenter"><form style="margin: 0pt; padding: 0pt;" method="post" action="production.php"><div><input name="referer" value="production.php" type="hidden" /><input name="filter_systemID" value="<!--[$filter_regionID]-->" type="hidden" /><input name="filter_pos_id" value="<!--[$filter_pos_id]-->" type="hidden" /><input name="filter_systemID" value="<!--[$filter_systemID]-->" type="hidden" /><input name="structure_id" value="<!--[$silo.silo_id]-->" type="hidden" /><input size="7" name="new_amount" value="" style="text-align:right;" type="text" /> <input name="action" value="Update Amount" class="mainoption" type="submit" /></div></form></td>
      <td class="txtright" ><!--[formatnumber value=$silo.material_amount]-->&nbsp;&nbsp;</td>
      <!--[math equation="x*y" x=$silo.material_amount y=$silo.material_volume|default:0 assign='matvolume']-->
      <td class="txtright"><!--[formatnumber value=$matvolume]-->&nbsp;&nbsp;</td>
      <td class="txtcenter">&nbsp;<!--[$silo.direction]-->&nbsp;</td>
      <td class="txtcenter" style="border:1px <!--[if $silo.full or $silo.empty]-->red<!--[else]-->#aaaaaa<!--[/if]--> solid;"><!--[if $silo.full]-->FULL<!--[elseif $silo.empty]-->EMPTY<!--[else]--><!--[daycalc hours=$silo.hourstofill]--><!--[/if]--><!--[if $silo.silo_link]--> (Link: <!--[$silo.silo_link]-->)<!--[/if]--></td>
    </tr>
  <!--[/foreach]-->
    <tr>
      <td colspan="9"><hr></td>
    </tr>
  <!--[/foreach]-->
  </tbody>
  </table>


<!--[include file='footer.tpl']-->
