<!--[include file='header.tpl']-->

  <h2>Administration</h2>
  <p class="mcenter">
  <!--[if $installchecker]-->
      <span style="color:red;font-weight:bold;">WARNING: install.php is still accessible. Please rename/remove install.php from the POS Tracker install directory.</span><br /><br />
  <!--[/if]-->
	  &nbsp; &nbsp; | &nbsp; &nbsp;
    <a href="admin.php?op=modules" title="Addons Management">Addons</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	<a href="upgrade.php" title="DB Upgrades">DB Upgrades</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	  <a href="admin.php?action=moons" title="Moons Management">Moon Database</a>
      &nbsp; &nbsp; |
      <br /><br />
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="#apiupdate" title="API Data Updates">API Data</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="#apikeys" title="API Key Management">API Keys</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="#users" title="Users Management">Users</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	  <a href="#prices" title="Global Price List">Price List</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	  <a href="#settings" title="POS Tracker Settings">Settings</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	  <a href="#version" title="Version Checker">Version Check</a>
      &nbsp; &nbsp; |
      <br /><br />
  </p>
  <hr />
  <!--[if $action]-->
    <!--[if $action eq 'updatealliance']-->
      <p>
        Success<br />
        Total Number of Alliances: <!--[$results.counttotal]--><br />
        Total Number of Updates: <!--[$results.updatestotal]-->
        <br /><br />
        <a href="admin.php" title="Done">Done</a>
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
        <a class="link" href="admin.php" title="Done">Done</a>
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
        <a href="admin.php" title="Done">Done</a>
      </p>
	
	<!--[elseif $action eq 'updatejobs']-->
      <p>
      <!--[if $results]-->
        Success<br />
        Jobs Checked and Updated!<br />
      <!--[else]-->
        ERROR!!
      <!--[/if]-->
        <br /><br />
        <a href="admin.php" title="Done">Done</a>
      </p>
	
	<!--[elseif $action eq 'updatepricesapi']-->
      <p>
      <!--[if $results]-->
        Success! Prices imported from the awesome <a href="http://eve-marketdata.com" target="_blank">EVE-Marketdata.com</a> website!<br />
      <!--[else]-->
        ERROR!! Prices couldn't update.
      <!--[/if]-->
        <br /><br />
        <a href="admin.php" title="Done">Done</a>
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
  	<!--[if $vcheck !="Your installation is up to date!" && $vcheck !=""]-->
	  <span style="font-weight:bold;"><!--[$vcheck]--></span><hr />
	<!--[/if]-->
    <h4 class="pageTitle"><a name="apiupdates"></a>API Data</h4>
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
          <tr>
            <th class="mbground hcolor">API Type</th>
            <th class="mbground hcolor">Last Updated</th>
            <th class="mbground hcolor">Manual Update</th>
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
	    <td>Industrial Jobs from API</td>
	    <td><!--[$jobtime]--></td>
	    <td><form method="post" action="admin.php"><input type="hidden" name="action" value="updatejobs" /><input type="submit" value="UPDATE NOW" /></form></td>
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
          <tr>
            <th class="mbground hcolor">Corp</th>
            <th class="mbground hcolor">KeyID</th>
            <th class="mbground hcolor">vCode (first 5 characters)</th>
            <th class="mbground hcolor">Remove</th>
          </tr>
        </thead>
        <tbody>
        <!--[foreach item='key' from=$keys]-->
          <tr>
            <td><!--[$key.corp|default:"&nbsp;"]--></td>
            <td><!--[$key.userID|default:"&nbsp;"]--></td>
            <td><!--[$key.shortkey|default:"&nbsp;"]--></td>
            <td><!--[if $userinfo.access == 5]--><input type="checkbox" name="keyremove[<!--[$key.id]-->]" /><!--[else]-->&nbsp;<!--[/if]--></td>
           </tr>
        <!--[/foreach]-->
          <tr>
            <td colspan="4"><input type="submit" value="Update/Remove" /></td>
          </tr>
        </tbody>
        </table>
      </div>
      </form>
     <h4 class="pageTitle">Add an <a href="https://support.eveonline.com/api" target="_blank">API Key</a></h4>
      <form method="post" action="admin.php?action=getcharacters">
      <div>
        KeyID: <input type="text" name="userid" size="10" /> vCode: <input type="text" name="apikey" size="35" /> <input type="submit" value="Select Character" />
      </div>
      </form>
	   (Requires: StarbaseList/StarbaseDetail/CorporationSheet/IndustryJobs)
     <br />
    </div>
	
<hr />
    <h4 class="pageTitle"><a name="users"></a>Registered Users</h4>
    <div class="mcenter">
      <form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="updateusers" />
        <table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr>
			
			<th class="mbground hcolor">Corp</th>
			
			<th class="mbground hcolor">Other Corps</th>
			
            <th class="mbground hcolor">Jobs</th>
			
			<th class="mbground hcolor">Production</th>
			
			<th class="mbground hcolor">ReStocker</th>
			
			<th class="mbground hcolor">Trusted</th>
			
			<th class="mbground hcolor">SubAdmin</th>
			
			<th class="mbground hcolor">Enabled</th>
			
			<th class="mbground"><font color="red">Remove</font></th>
			
            <!--<th>Modify</th>-->
          </tr>
        </thead>
		
		
		<!--[foreach item='user' from=$users]-->
		<!--[assign var=auser value="."|explode:$user.access]-->
		<!--[if $user.name != "Admin"]-->
		<!--[if ((!in_array('6', $auser) && in_array('6', $access)) || in_array('5', $access))]-->
				
		<input type="hidden" name="UserList[<!--[$user.id]-->]" value="<!--[$user.id]-->">
		<tbody class="auser">
		<tr>
		<td colspan="2"><b><!--[$user.name]--></b></td>
		<td colspan="2">Corp: <!--[$user.corp|default:"&nbsp;"]--></td>
		<td colspan="3">Email: <!--[$user.email|default:"&nbsp;"]--></td>
		<td colspan="2">Email Status: <!--[$awaylevel[$user.away]]--></td>
		</tr>
		
		<tr>
		<td>
		<select name="CorpAccess[<!--[$user.id]-->]" <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->>
		<option value="">No Access</option>
		<option value="20" <!--[if (in_array('20', $auser))]-->selected="yes"<!--[/if]-->>View</option>
		<option value="21" <!--[if (in_array('21', $auser))]-->selected="yes"<!--[/if]-->>Edit</option>
		<option value="22" <!--[if (in_array('22', $auser))]-->selected="yes"<!--[/if]-->>Secret</option>
		</select>
		</td>
		
		<td>
		<select name="OtherCorpAccess[<!--[$user.id]-->]" <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->>
		<option value="">No Access</option>
		<option value="50" <!--[if (in_array('50', $auser))]-->selected="yes"<!--[/if]-->>View</option>
		<option value="51" <!--[if (in_array('51', $auser))]-->selected="yes"<!--[/if]-->>Edit</option>
		<option value="52" <!--[if (in_array('52', $auser))]-->selected="yes"<!--[/if]-->>Secret</option>
		</select>
		</td>
		
		<td>
		<select name="JobAccess[<!--[$user.id]-->]" <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->>
		<option value="">No Access</option>
		<option value="40" <!--[if (in_array('40', $auser))]-->selected="yes"<!--[/if]-->>Current</option>
		<option value="41" <!--[if (in_array('41', $auser))]-->selected="yes"<!--[/if]-->>Past</option>
		<option value="45" <!--[if (in_array('45', $auser))]-->selected="yes"<!--[/if]-->>All Corps</option>
		</select>
		</td>
		
		<td>
		<select name="ProdAccess[<!--[$user.id]-->]" <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->>
		<option value="">No Access</option>
		<option value="42" <!--[if (in_array('42', $auser))]-->selected="yes"<!--[/if]-->>Own</option>
		<option value="43" <!--[if (in_array('43', $auser))]-->selected="yes"<!--[/if]-->>Same Corp</option>
		<option value="44" <!--[if (in_array('44', $auser))]-->selected="yes"<!--[/if]-->>All Corps</option>
		</select>
		</td>
		
		<td>
		<select name="ReStockerAccess[<!--[$user.id]-->]" <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->>
		<option value="">N/A</option>
		</select>
		</td>
		
		<td><input type="checkbox" name="TrustAccess[<!--[$user.id]-->]" value="83" <!--[if (in_array('83', $auser))]-->checked<!--[/if]--> <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->></td>
		<td><input type="checkbox" name="SubAdminAccess[<!--[$user.id]-->]" value="6" <!--[if (in_array('6', $auser))]-->checked<!--[/if]-->></td>
		<td><input type="checkbox" name="UserEnabled[<!--[$user.id]-->]" value="1" <!--[if (in_array('1', $auser) || in_array('6', $auser))]-->checked<!--[/if]--> <!--[if (in_array('6', $auser))]-->disabled<!--[/if]-->></td>
		<td><input type="checkbox" name="userremove[<!--[$user.id]-->]" <!--[if (in_array('6', $access))]-->disabled<!--[/if]-->></td>
		
		</tr>
		</tbody>
		<!--[/if]-->
        <!--[/if]-->
        <!--[/foreach]-->
		
		<tbody>
          <tr><td colspan="9"><input type="submit" value="Update/Remove" /></td></tr>
        </tbody>
        </table>
      </div>
      </form>
	  <hr />
    <h4 class="pageTitle"><a name="prices"></a>Global Price List</h4>
    <div class="mcenter">
      <form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="updateprices" />
        <table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr>
			<th class="mbground hcolor">Item</th>
			
			<th class="mbground hcolor">Value</th>	
          </tr>
        </thead>
		
		<!--[foreach from=$prices key=k item=v]-->
		<tbody class="auser">
		<tr>
		<td><!--[$k]--></td>
		<td><input type="text" name="PricesUpdate[<!--[$k]-->]" value="<!--[$v]-->"></td>
		</tr>
		</tbody>
        <!--[/foreach]-->
		<tbody>
          <tr><td colspan="9"><input type="submit" value="Update Prices" /></form><form method="post" action="admin.php"><input type="hidden" name="action" value="updatepricesapi" /><input type="submit" value="Update Prices via EVE-Marketdata" /></form></td></tr>
        </tbody>
        </table>
      </div>
    
	<hr />
    <h4 class="pageTitle"><a name="settings"></a>POS Tracker Settings</h4>
    <div class="mcenter">
	<form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="updatesettings" />
		<table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr>
		  <th class="mbground hcolor">Name</th>
          <th class="mbground hcolor">Current Setting</th>
		  </tr>
		</thead>
		<!--[foreach item='setting' from=$settings]-->
		<tbody class="auser">
		  <tr>
		  <td width="30%"><!--[$setting.name]--></td>
		  <td width="70%">
		  <!--[if ($setting.name == "Hidden Jobs")]-->
		  <select name="SettingsUpdate[Hidden Jobs]">
		  <option value="0" <!--[if ($setting.gsetting==0)]-->selected="yes"<!--[/if]-->>No Jobs Hidden</option>
		  <option value="1" <!--[if ($setting.gsetting==1)]-->selected="yes"<!--[/if]-->>Titans and SuperCarriers</option>
		  <option value="2" <!--[if ($setting.gsetting==2)]-->selected="yes"<!--[/if]-->>All Capitals</option>
		  <option value="3" <!--[if ($setting.gsetting==3)]-->selected="yes"<!--[/if]-->>All Ships</option>
		  </select>
		  <!--[elseif ($setting.name == "Main Market Hub")]-->
		  <select name="SettingsUpdate[Main Market Hub]">
		  <option value="10000002" <!--[if ($setting.gsetting==10000002 || $setting.gsetting=="")]-->selected="yes"<!--[/if]-->>Jita - The Forge</option>
		  <option value="10000043" <!--[if ($setting.gsetting==10000043)]-->selected="yes"<!--[/if]-->>Amarr - Domain</option>
		  <option value="10000030" <!--[if ($setting.gsetting==10000030)]-->selected="yes"<!--[/if]-->>Rens - Heimatar</option>
		  <option value="10000032" <!--[if ($setting.gsetting==10000032)]-->selected="yes"<!--[/if]-->>Dodixie - Sinq Laison</option>
		  <!--[elseif ($setting.name == "Version Checker")]-->
		  <select name="SettingsUpdate[Version Checker]">
		  <option value="0" <!--[if ($setting.gsetting==0 || $setting.gsetting=="")]-->selected="yes"<!--[/if]-->>Manual</option>
		  <option value="1" <!--[if ($setting.gsetting==1)]-->selected="yes"<!--[/if]-->>Automatic</option>
		  </select>
		  <!--[/if]--> 
		  </td>
		  </tr>
		 </tbody>
		 <!--[/foreach]-->
		 <tbody>
		 <tr>
		  <td colspan="4"><input type="submit" value="Update Settings" /></td>
		  </tr>
		  </tbody>
        </table>
	  </div>
    </form>

	<hr />
    <h4 class="pageTitle"><a name="version"></a>Version Checker</h4>
    <div class="mcenter">
	<form method="post" action="admin.php">
      <div>
        <input type="hidden" name="action" value="versioncheck" />
		<table class="mcenter tracktable" style="width:640px;">
        <thead>
          <tr>
		  <th class="mbground hcolor">Installed Version</th>
          <th class="mbground hcolor">Latest Version</th>
		<tbody>
		  <tr>
		  <td width="25%"><!--[$version]--></td><td width="75%"><!--[$vcheck]--></td>
		  </tr>
		  <tr>
		  <td colspan="2"><input type="submit" value="Check Version" /></td>
		  </tr>
		  </tbody>
        </table>
	  </div>
    </form>
    </div>
  <!--[/if]-->


<!--[include file='footer.tpl']-->
