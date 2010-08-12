<!--[* $Id: outpost.tpl 168 2008-09-20 07:24:02Z stephenmg $ *]-->
<!--[include file='header.tpl']-->
  <h3 class="pageTitle">Outpost Tracker</h3>
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
      <td><button type="button" onclick="window.location.href='viewoutpost.php?i=<!--[$outpost.outpost_id]-->'">View</button><button type="button" onclick="window.location.href='editoutpost.php?i=<!--[$outpost.outpost_id]-->'">Edit</button><button type="button" onclick="window.location.href='outpost.php?i=<!--[$outpost.outpost_id]-->'">Delete</button></td>
    </tr>

  <!--[/foreach]-->

  </tbody>
  </table>

  <div class="mcenter"><a class="link" href="addoutpost.php" title="Add a new Outpost">Add a New Outpost</a></div>
<!--[include file='footer.tpl']-->