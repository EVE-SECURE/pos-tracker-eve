<!--[* $Id: admin.tpl 244 2009-04-26 17:25:32Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h2>Administration</h2>
  <p class="mcenter">
    <span style="color:#1B3169;">
    <!--[if $access]-->
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="#apiupdate" title="API Data Updates">API Data</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="#apikeys" title="API Key Management">API Keys</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="admin.php?action=moons" title="Moons Management">Moons</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="#users" title="Users Management">Users</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="admin.php?op=modules" title="Addons Management">Addons</a>
      &nbsp; &nbsp; &nbsp; |
    <!--[/if]-->
      <br /><br />
    </span>
  </p>

  <hr />
  <!--[if $action]-->
    <!--[if $action eq 'updatealliance']-->
      <p>
        Success<br />
        Total Number of Alliances: <!--[$results.counttotal]--><br />
        Total Number of Updates: <!--[$results.updatestotal]-->
        <br /><br />
        <a class="arialwhite14 txtunderlined" href="admin.php" title="Done">Done</a>
        <br /><br />
        <!--[if $results.updatestotal]-->
        Alliances Added:<br />
        <table class="mcenter tracktable" style="width:640px;">
        <!--[foreach item='all' from=$results.alladded]-->
          <tr>
            <td><!--[$all.name]--></td>
            <td><!--[$all.shortName]--></td>
          </tr>
        <!--[/foreach]-->
        </table>
        <!--[/if]-->
      </p>
    <!--[elseif $action eq 'updatedatafromapi']-->
      <p>
        Success<br />
        Total Number of POS Added: <!--[$results.count_added]--><br />
        Total Number of POS Updated: <!--[$results.count_updated]--><br />
        Total POSes updated from API: <!--[$results.count_towers]--><br />
	<br />
        <a class="arialwhite14 txtunderlined" href="admin.php" title="Done">Done</a>
        <br /><br />
        <!--[if $results]-->
        Towers List:<br />
        <table class="mcenter tracktable" style="width:640px;">
        <!--[*assign var='posupdate' value=$results.posupdate*]-->
        <!--[foreach item='posinfo' key='evetowerID' from=$posupdate]-->
          <tr>
            <td><!--[$evetowerID]--></td>
            <td><!--[$posinfo]--></td>
          </tr>
        <!--[/foreach]-->
        </table>
        <!--[/if]-->
      </p>
    <!--[elseif $action eq 'updatesovereignty']-->
      <p>
      <!--[if $sovcount]-->
        Success<br />
        Systems Updated: <!--[$sovcount]--><br />
      <!--[else]-->
        ERROR!!
      <!--[/if]-->
        <br /><br />
        <a class="arialwhite14 txtunderlined" href="admin.php" title="Done">Done</a>
      </p>

    <!--[elseif $action eq 'getcharacters']-->
      <!--[foreach item='character' from=$characters]-->
      <!--[assign var='alliance' value=$character.alliance]-->
      <div style="margin-bottom:25px;">
      <form id="u_<!--[$character.characterID]-->" method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="saveapi" />
        <input type="hidden" name="apikey" value="<!--[$apikey]-->" />
        <input type="hidden" name="userid" value="<!--[$userid]-->" />
        <input type="hidden" name="characterID" value="<!--[$character.characterID]-->" />
        <input type="hidden" name="corporationName" value="<!--[$character.corporationName]-->" />
        <input type="hidden" name="corporationID" value="<!--[$character.corporationID]-->" />
        <input type="hidden" name="allianceName" value="<!--[$alliance.allianceName]-->" />
        <input type="hidden" name="allianceID" value="<!--[$alliance.allianceID]-->" />
        <input type="submit" value="Save <!--[$character.name]--> API Key" />
      </div>
      </form>
      </div>
      <!--[/foreach]-->


    <!--[/if]-->
  <!--[else]-->
    <h4 class="pageTitle"><a style="color:#ffffff;" name="moons"></a>Manage Moons</h4>
    <div class="mcenter">
      <a href="admin.php?action=moons" title="Moon Database">Managed Moon Database</a>
      <br />
    </div>
    <hr />

    <h4 class="pageTitle"><a style="color:#ffffff;" name="apiupdates"></a>API Data</h4>
    <div>
      <!--[if $allyupdate]-->
      <span style="color:red;font-weight:bold;">Warning, Your Alliance data is out of date. <!--[$allytime]--></span><br />
      <!--[/if]-->
      <!--[if $systupdate]-->
      <span style="color:red;font-weight:bold;">Warning, Your Sovereignty data is out of date. <!--[$sovtime]--></span><br />
      <!--[/if]-->
      <!--[if $apiupdate]-->
      <span style="color:red;font-weight:bold;">Warning, Your API POS data is out of date. <!--[$apitime]--></span><br />
      <!--[/if]-->

      
      <div>
        <table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr class="trackheader">
            <th style="color:#CCCCCC;">API Type</th>
            <th style="color:#CCCCCC;">Last Updated</th>
            <th style="color:#CCCCCC;">Manual Update</th>
          </tr>
        </thead>
        <tbody>
	  <tr>
	    <td>Alliance Database</td>
	    <td><!--[$allytime]--></td>
	    <td><form method="post" action="admin.php"><input type="hidden" name="action" value="updatealliance" /><input type="submit" value="UPDATE NOW" /></form></td>
	  </tr>
	  <tr>
	    <td>Sovereignty Database</td>
	    <td><!--[$sovtime]--></td>
	    <td><form method="post" action="admin.php"><input type="hidden" name="action" value="updatesovereignty" /><input type="submit" value="UPDATE NOW" /></form></td>
	  </tr>
	  <tr>
	    <td>POS Update from API</td>
	    <td><!--[$apitime]--></td>
	    <td><form method="post" action="admin.php"><input type="hidden" name="action" value="updatedatafromapi" /><input type="submit" value="UPDATE NOW" /></form></td>
	  </tr>
	</table>
      </div>
    </div>
    <hr />

    <h4 class="pageTitle"><a name="apikeys"></a>API Key Manager</h4>
    <div class="mcenter">
      <form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="updatekey" />
        <table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr class="trackheader">
            <th style="color:#CCCCCC;">Corp</th>
            <th style="color:#CCCCCC;">UserID</th>
            <th style="color:#CCCCCC;">API Key (first 5 characters)</th>
            <th style="color:#CCCCCC;">Remove</th>
          </tr>
        </thead>
        <tbody>
        <!--[foreach item='key' from=$keys]-->
          <tr>
            <td><!--[$key.corp|default:"&nbsp;"]--></td>
            <td><!--[$key.userID|default:"&nbsp;"]--></td>
            <td><!--[$key.shortkey|default:"&nbsp;"]--></td>
            <td><!--[if $userinfo.access > 4]--><input type="checkbox" name="keyremove[<!--[$key.id]-->]" /><!--[else]-->&nbsp;<!--[/if]--></td>
           </tr>
        <!--[/foreach]-->
          <tr>
            <td colspan="4"><input type="submit" value="Update/Remove" /></td>
          </tr>
        </tbody>
        </table>
      </div>
      </form>
     <h4 class="pageTitle">Add an API Key</h4>
      <form method="post" action="admin.php?action=getcharacters">
      <div>
        USERID: <input type="text" name="userid" size="10" /> APIKEY: <input type="text" name="apikey" size="35" /> <input type="submit" value="Select Character" />
      </div>
      </form>
     <br />
    </div>

    <hr />
    <h4 class="pageTitle"><a style="color:#ffffff;" name="users"></a>Registered Users</h4>
    <div class="mcenter">
      <form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="updateusers" />
        <table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr class="trackheader">
            <th style="color:#CCCCCC;">Name</th>
            <th style="color:#CCCCCC;">Corp</th>
            <th style="color:#CCCCCC;">Email</th>
            <th style="color:#CCCCCC;">Away</th>
            <th style="color:#CCCCCC;">Access</th>
            <th style="color:#CCCCCC;">Highly Trusted</th>
            <th style="color:#CCCCCC;">Remove</th>
            <!--<th>Modify</th>-->
          </tr>
        </thead>
        <tbody>
        <!--[foreach item='user' from=$users]-->
          <tr>
            <td><!--[$user.name]--></td>
            <td><!--[$user.corp|default:"&nbsp;"]--></td>
            <td><!--[$user.email|default:"&nbsp;"]--></td>
            <td><!--[$awaylevel[$user.away]]--></td>
            <td><!--[if $user.access < $userinfo.access]--><select name="useraccess[<!--[$user.id]-->]"><!--[html_options options=$optaccess selected=$user.access]--></select><!--[else]--><!--[$accesslevel[$user.access]]--><input type="hidden" name="access[<!--[$user.id]-->]" value="<!--[$user.access]-->" /><!--[/if]--></td>
            <td><!--[if $userinfo.access > 4]--><select name="usertrust[<!--[$user.id]-->]"><!--[html_options options=$opttrust selected=$user.highly_trusted]--></select><!--[else]--><!--[$opttrust[$user.highly_trusted]]--><input type="hidden" name="usertrust[<!--[$user.id]-->]" value="<!--[$user.highly_trusted]-->" /><!--[/if]--></td>
            <td><!--[if $user.access < $userinfo.access]--><input type="checkbox" name="userremove[<!--[$user.id]-->]" /><!--[else]-->&nbsp;<!--[/if]--></td>
          </tr>
        <!--[/foreach]-->
          <tr>
            <td colspan="7"><input type="submit" value="Update/Remove" /></td>
          </tr>
        </tbody>
        </table>
      </div>
      </form>
	  Highly Trusted requires the person to be View-All Manager or Director in order to function. Secret POS will show to Fuel Techs if they are actually assigned to it and do not need Highly Trusted selected.
    </div>
  <!--[/if]-->


<!--[include file='footer.tpl']-->
