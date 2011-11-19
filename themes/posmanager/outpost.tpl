<!--[include file='header.tpl']-->
  <table class="mcenter tracktable" style="width:100%;" cellspacing="0">
  <tbody>
    <tr>
      <td class="mbground hcolor">Outpost Name</td>
      <!--[*<td>System</td>*]-->
      <td class="mbground hcolor">Last Update</td>
      <td class="mbground hcolor">Status</td>
      <td class="mbground hcolor">Action</td>

    </tr>

  <!--[foreach item='outpost' from=$outposts]-->
    <tr style="background-color:<!--[$pos.bgcolor]-->;">
      <td><!--[$outpost.outpost_name]--></td>
      <!--[*<td><!--[$outpost.systemID]--></td>*]-->
      <td><!--[$outpost.lastupdate]--></td>
      <td><!--[$outpost.outpostdaycalc]--></td>
      <td>
		<a href="viewoutpost.php?i=<!--[$outpost.outpost_id]-->"><img src="images/icons/zoom.png" border="0" alt="View" title="View" /></a>
		<!--[if ( in_array('61', $access) || (in_array('5', $access)) || in_array('6', $access) )]-->
	    <a href="editoutpost.php?i=<!--[$outpost.outpost_id]-->"><img src="images/icons/pencil.png" border="0" alt="Edit" title="Edit" /></a>
		<!--[/if]-->
		<!--[if ( (in_array('83', $access) && in_array('61', $access) ) || (in_array('5', $access)) || in_array('6', $access) )]-->
	    <a href="outpost.php?i=<!--[$outpost.outpost_id]-->"><img src="images/icons/delete.png" border="0" alt="Delete" title="Delete" /></a>
		<!--[/if]-->
	  </td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>

  <div class="mcenter"><a class="link" href="addoutpost.php" title="Add a new Outpost">Add a New Outpost</a></div>
<!--[include file='footer.tpl']-->