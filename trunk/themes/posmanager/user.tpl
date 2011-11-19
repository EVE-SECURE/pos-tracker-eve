<!--[include file='header.tpl']-->
  <div class="mcenter">
    <form method="post" action="user.php">
    <div>
      <input type="hidden" name="id"     value="<!--[$id]-->" />
      <input type="hidden" name="action" value="changeinfo" />
      <table class="mcenter tracktable txtleft" style="width:640px;">
      <thead>
        <tr>
          <td class="mbground hcolor txtcenter" colspan=2>User Information</th>
        <tr>
      </thead>
      <tbody>
        <tr>
          <td class="mbground hcolor">Username</th>
          <td><!--[$name]--></td>
        </tr>
        <tr>
          <td class="mbground hcolor" rowspan="2">New password</th>
          <td><input size=40 type="password" name="newpass" value="" /></td>
        </tr>
        <tr>
          <td><input size=40 type="password" name="newpass2" value="" /></td>
        </tr>
        <tr>
          <td class="mbground hcolor">Your email</th>
          <td><input size=40 type="text" name="email" value="<!--[$email]-->" /></td>
        </tr>
        <tr class="txtcenter">
          <td colspan="2"><input type="submit" value="Update Profile" /></td>
        </tr>
      </tbody>
      </table>
	  <!--[assign var=utrack value="."|explode:$user_track]-->
	  <table class="mcenter tracktable txtleft" style="width:640px;">
      <thead>
        <tr>
          <td class="mbground hcolor txtcenter" colspan=2>User Settings</th>
        <tr>
      </thead>
      <tbody>
        <tr>
          <td class="mbground hcolor">Away Status</td>
          <td><!--[html_options options=$awaystatus name='away' selected=$away]--></td>
        </tr>
		<tr>
          <td class="mbground hcolor">Theme</td>
          <td><!--[html_options options=$themeset name='theme_id' selected=$theme_id]--></td>
        </tr>
		<tr>
          <td class="mbground hcolor">POS Track Default Tower Display</td>
          <td><!--[html_options options=$user_track_display name='user_track_display' selected=$utrack[0]]--></td>
        </tr>
		<tr>
          <td class="mbground hcolor">POS Track Default Sort</td>
          <td><!--[html_options options=$user_track_sort name='user_track_sort' selected=$utrack[1]]--></td>
        </tr>
        <tr class="txtcenter">
          <td colspan="2"><input type="submit" value="Update Settings" /></td>
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
		<BR><b>Note:</b> You must have this tracker site page trusted in order for the changes to go through correctly.<br><br> Directions: While on this page click Options -> Trusted Sites. Click Trust Site.
      </div>
      </form>
    <!--[else]-->
      <table class="mcenter tracktable" style="width:500px;">
      <tbody>
        <tr>
          <td class="mbground hcolor">Update Corp/Alliance</td>
          <td>ERROR: Need to use the in-game browser</td>
        </tr>
      </tbody>
      </table>
    <!--[/if]-->
    </div>
    <br /><hr /><br />
  </div>

<!--[include file='footer.tpl']-->
