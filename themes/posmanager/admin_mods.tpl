<!--[* $Id: admin_mods.tpl 208 2008-10-29 10:28:37Z eveoneway $ *]-->
<!--[include file='header.tpl']-->


  <h2>Administration - Modules</h2>
  <h4>Module List</h4>
  <div class="mcenter">
    <form method="post" action="admin.php">
    <div>
      <input type="hidden" name="op"     value="modules" />
      <input type="hidden" name="action" value="updatestatus" />
      <table class="mcenter tracktable" style="width:640px;">
      <thead>
        <tr class="trackheader">
          <th>Name</th>
          <th>Status</th>
          <th>User</th>
          <th>Admin</th>
          <th>functions</th>
          <!--<th>Modify</th>-->
        </tr>
      </thead>
      <tbody>
      <!--[foreach item='mod' from=$mods]-->
        <tr>
          <td><!--[if $mod.modstate eq 1]--><a href="module.php?name=<!--[$mod.modname]-->" title="<!--[$mod.modname]-->"><!--[/if]--><!--[$mod.modname]--><!--[if $mod.modstate eq 1]--></a><!--[/if]--></td>
          <td><!--[$mod.modstate]--></td>
          <td><!--[if $mod.user]-->Yes<!--[else]-->No<!--[/if]--></td>
          <td><!--[if $mod.admin]-->Yes<!--[else]-->No<!--[/if]--></td>
          <td><!--[if $mod.modstate eq 0]--><a href="admin.php?op=modules&amp;modname=<!--[$mod.modname]-->&amp;func=install" title="Install <!--[$mod.modname]-->">Install</a><!--[elseif $mod.modstate eq 1]--><a href="admin.php?op=modules&amp;modname=<!--[$mod.modname]-->&amp;func=uninstall" title="Install <!--[$mod.modname]-->">Uninstall</a><!--[/if]--></td>
        </tr>
      <!--[/foreach]-->
        <tr>
          <td colspan="5"><input type="submit" value="Update" /></td>
        </tr>
      </tbody>
      </table>
    </div>
    </form>
  </div>



<!--[include file='footer.tpl']-->