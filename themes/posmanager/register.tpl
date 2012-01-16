<!--[include file='header.tpl']-->


  <h2>Welcome to the POS Tracker</h2>
  <div class="mcenter">
  <table class="mcenter tracktable txtleft" style="width:500px;">
    <thead>
      <tr>
        <td class="mbground hcolor txtcenter" colspan=2>API Registration</td>
      <tr>
    </thead>
<!--[if $action eq 'getchars']-->
    <!--[foreach item='character' from=$characters]-->
    <!--[assign var='alliance' value=$character.alliance]-->
  <form method="post" action="register.php">
    <tr>
	<td class="mbground hcolor">Char Details</td>
	<td>
	  <input type="hidden" name="api_userid" value="<!--[$api_userid]-->" />
	  <input type="hidden" name="api_key" value="<!--[$api_key]-->" />
	  <input type="hidden" name="charname" value="<!--[$character.name]-->" />Charname: <!--[$character.name]-->
	  <input type="hidden" name="characterID" value="<!--[$character.characterID]-->" />(<!--[$character.characterID]-->)<br>
	  <input type="hidden" name="corporationName" value="<!--[$character.corporationName]-->" />Corp name: <!--[$character.corporationName]-->
	  <input type="hidden" name="corporationID" value="<!--[$character.corporationID]-->" />(<!--[$character.corporationID]-->)<br>
	  <input type="hidden" name="allianceName" value="<!--[$alliance.allianceName]-->" />Alliance name: <!--[$alliance.allianceName|default:"None"]-->
	  <input type="hidden" name="allianceID" value="<!--[$alliance.allianceID]-->" />(<!--[$alliance.allianceID]-->)<br>
	</td>
    </tr>
    <tr>
	<td class="txtcenter" colspan=2><input type="hidden" name="action" value="getuserinfo" /><input class="mButton" type="submit" value="Use <!--[$character.name]--> Char Details" /></td>
    </tr>
  </form>
      <!--[/foreach]-->
<!--[elseif $action eq 'getuserinfo']-->
  <form method="post" action="register.php">
	<input type="hidden" name="api_userid" value="<!--[$api_userid]-->" />
	<input type="hidden" name="api_key" value="<!--[$api_key]-->" />
	<input type="hidden" name="charname" value="<!--[$charname]-->" />
	<input type="hidden" name="characterID" value="<!--[$characterID]-->" />
	<input type="hidden" name="corporationName" value="<!--[$corporationName]-->" />
	<input type="hidden" name="corporationID" value="<!--[$corporationID]-->" />
	<input type="hidden" name="allianceName" value="<!--[$allianceName]-->" />
	<input type="hidden" name="allianceID" value="<!--[$allianceID]-->" />
    <tr>
      <td class="mbground hcolor">Login name</td>
      <td><!--[$charname]--></td>
    </tr>
    <tr>
      <td class="mbground hcolor">eMail</td>
      <td><input type="text" name="email" value="<!--[$email]-->" size="40" maxlength="128" /></td>
    </tr>
    <tr>
      <td class="mbground hcolor" rowspan="2">Password</td>
      <td><input type="password" name="pass" size="20" maxlength="40" /></td>
    </tr>
    <tr>
      <td><input type="password" name="pass2" size="20" maxlength="40" /></td>
    </tr>
    <tr>
      <td colspan=2 class="mcenter txtcenter"><input type="hidden" name="action" value="saveaccount" /><input class="mButton" type="submit" value="Create Account" /></td>
    <tr>
  </form>
<!--[else]-->
  <form method="post" action="register.php">
    <tr>
      <td class="mbground hcolor">KeyID</td>
      <td><input size=20 type="text" name="api_userid" value="<!--[$api_userid]-->" /></td>
    </tr>
    <tr>
      <td class="mbground hcolor">vCode</td>
      <td><input size=64 type="text" name="api_key" value="<!--[$api_key]-->" maxlength="64"/></td>
    </tr>
    <tr>
      <td colspan="2" class="mcenter txtcenter"><input type="hidden" name="action" value="getchars" /><input class="mButton" type="submit" value="Get Characters" /></td>
    </tr>
	<tr>
      <td colspan="2" class="mcenter txtcenter"><a href="https://support.eveonline.com/api/Key/CreatePredefined/8388608" target="_blank">EVE API Link</a></td>
    </tr>
  </form>
<!--[/if]-->
  </table>
  </div>

<!--[include file='footer.tpl']-->
