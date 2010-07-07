<!--[* $Id: user.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h3 class="pageTitle">User Panel</h3>
  <div class="mcenter">
    <form method="post" action="user.php">
    <div>
      <input type="hidden" name="id"     value="<!--[$id]-->" />
      <input type="hidden" name="action" value="changeinfo" />
      <table class="mcenter tracktable txtleft" style="width:500px;">
      <thead>
        <tr>
          <td class="trackheader txtcenter" style="color:#CCCCCC;" colspan=2>User Information</th>
        <tr>
      </thead>
      <tbody>
        <tr>
          <td class="trackheader" style="color:#CCCCCC;">Username</th>
          <td><!--[$name]--></td>
        </tr>
        <tr>
          <td class="trackheader" style="color:#CCCCCC;" rowspan="2">New password</th>
          <td><input size=40 type="password" name="newpass" value="" /></td>
        </tr>
        <tr>
          <td><input size=40 type="password" name="newpass2" value="" /></td>
        </tr>
        <tr>
          <td class="trackheader" style="color:#CCCCCC;">Your email</th>
          <td><input size=40 type="text" name="email" value="<!--[$email]-->" /></td>
        </tr>
        <tr>
          <td class="trackheader" style="color:#CCCCCC;">Away Status</td>
          <td><!--[html_options options=$awaystatus name='away' selected=$away]--></td>
        </tr>
        <tr class="txtcenter">
          <td colspan="2"><input type="submit" value="Change Info" /></td>
        </tr>
      </tbody>
      </table>
    </div>
    </form>
    <div class="mcenter txtcenter">
    <!--[if $IS_IGB]-->
      <form method="post" action="user.php">
      <div>
        <input type="hidden" name="action" value="updatecorpinfo" />
        <input type="submit" value="Update Corp/Alliance" />
      </div>
      </form>
    <!--[else]-->
      <table class="mcenter tracktable" style="width:500px;">
      <tbody>
        <tr>
          <td class="trackheader" style="color:#CCCCCC;">Update Corp/Alliance</td>
          <td>ERROR: Need to use the in-game browser</td>
        </tr>
      </tbody>
      </table>
    <!--[/if]-->
    </div>
    <br /><hr /><br />
  </div>

<!--[include file='footer.tpl']-->
