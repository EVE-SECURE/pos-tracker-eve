<!--[include file='install/install_header.tpl']-->
<div class="mcenter">
    <div class="txtleft">
    <!--[if $step eq 1]-->
      <strong><span>Thank you for choosing POS-Tracker 5.0.2. FG Version! Please fill the form to set the database information.</span></strong>
      <ul>
        <li>Current PHP version: <!--[$phpversion]--> (Needs to be greater than 5.1.2)</li>
        <li>Your CURL Version: <!--[$curlversion.version]--><!--[if $curlversion.version eq '0']--> (fopen alternative: <!--[$fopen]-->)<!--[/if]--></li>
      </ul>
      <strong><span>Required Modules Installed</span></strong>
      <ul>
        <li>CURL: <!--[$curl]--><!--[if $curl eq 'No' && $fopen eq 'Yes']--> (Will use fopen)<!--[/if]--></li>
        <li>SimpleXML: <!--[$simpleXML]--></li>
        <li>Hash: <!--[$hash]--></li>
        <li>Register_globals: <!--[$register_globals]--></li>
        <li>cache/template_c: <!--[if $cache]-->OK<!--[else]--><span style="color:red;font-weight:bold;">NOT WRITABLE!</span><!--[/if]--></li>
        <li>eveconfig/dbconfig.php: <!--[if $dbconfig]-->OK<!--[else]--><span style="color:red;font-weight:bold;">NOT WRITABLE!</span><!--[/if]--></li>
      </ul>
      <form class="txtleft" method="post" action="install.php?step=2">
      <div style="margin-top:40px;">
        <input type="hidden" id="querycount" name="querycount" value="<!--[$querycount]-->" />
        <input type="hidden" id="querytotal" name="querytotal" value="<!--[$querytotal]-->" />
        <table style="width:740px;" summary="Database Configuration">
          <tr>
            <td>MySQL Host</td>
            <td><input type="text" id="dbhost" name="dbhost" value="localhost" /></td>
          </tr>
          <tr>
            <td>MySQL Database</td>
            <td><input type="text" id="dbname" name="dbname" value="" /></td>
          </tr>
          <tr>
            <td>MySQL Username</td>
            <td><input type="text" id="dbuname" name="dbuname" value="" /></td>
          </tr>
          <tr>
            <td>MySQL Password</td>
            <td><input type="password" id="dbpass" name="dbpass" value="" /></td>
          </tr>
          <tr>
            <td>Table Prefix</td>
            <td><input type="text" id="dbprefix" name="dbprefix" value="pos3_" /></td>
          </tr>
          <tr>
            <td>Upgrade From 2.1.x</td>
            <td><input type="checkbox" id="dbupgrade" name="dbupgrade" /> (Make sure the Prefix is the same as your current setup)</td>
          </tr>
          <tr>
            <td colspan="2"><hr /></td>
          </tr>
          <tr>
            <td colspan="2" class="txtleft">
              <input type="button" id="btnTest" value="test" onclick="ajax_CheckDB();" />
              <img id="loader" style="display:none;" src="images/loader.gif" alt="loader" />
              <img id="loaderblank" src="images/loader.blank.black.gif" alt="loaderblank" />
              <button type="button" id="btnWrite" onclick="ajax_WriteConfig();" disabled="disabled">Write Config</button>
              <img id="loader2" style="display:none;" src="images/loader.gif" alt="loader2" />
              <img id="loaderblank2" src="images/loader.blank.black.gif" alt="loaderblank2" />
              <button type="button" id="btnNext" disabled="disabled" onclick="ajax_InstallTables();">Install tables</button>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="txtleft"><div id="dbinfo" style="font-size: 11px;font-weight: bold;">&nbsp;</div></td>
          </tr>
        </table>
      </div>
      </form>
    <!--[elseif $step eq 2]-->
    <!--[if not $done]-->
      Problem?
    <!--[else]-->
      <strong><span>Tables created/updated successfully!</span></strong>
      <br /><br />
      This is to create the user <strong>'admin'</strong>. Please provide an email address and a password.<br />
      You must <strong>click</strong> the <strong>"Next"</strong> button if using the IGB!
      <form method="post" action="install.php?step=3">
      <div style="margin-top:10px;">
        <input type="hidden" name="name" value="<!--[if $IS_IGB]--><!--[$userinfo.username]--><!--[else]-->Admin<!--[/if]-->" />
        <table style="width:560px;" summary="Admin configuration">
          <tr>
            <td>Email Address:</td>
            <td><input type="text" name="email" maxlength="255" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="pass" maxlength="255" /></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" name="action" value="Next" /></td>
          </tr>
        </table>
      </div>
      </form>
    <!--[/if]-->
    <!--[elseif $step eq 4]-->
      <div class="mcenter txtcenter">
      <p>
        <a class="link" href="install.php?step=5" title="Next">Next</a>
      </p>
      </div>
      <table class="tracktable mcenter" style="font-size:11px; font-family: Arial, sans-serif;" summary="Moon Installation">
        <tr class="mbground">
          <td>Region</td>
          <td>Region ID</td>
          <td>File Name</td>
          <td>Currently Installed?</td>
          <td>Install/Uninstall?</td>
        </tr>
      <!--[foreach item='region' from=$regions]-->
        <tr>
          <td><!--[$region.regionName]--></td>
          <td><!--[$region.regionID]--></td>
          <td><!--[$region.file_name]--></td>
          <td><div id="row_<!--[$region.regionID]-->"><!--[if $region.installed]-->Yes<!--[else]-->No<!--[/if]--></div></td>
          <td style="width:100px;"><button type="button" id="region_<!--[$region.regionID]-->" onclick="ajax_InstallRegion(<!--[$region.regionID]-->);"><!--[if $region.installed]-->Uninstall<!--[else]-->Install<!--[/if]--></button>&nbsp;&nbsp;<img id="loaderblank_<!--[$region.regionID]-->" src="images/loader.blank.black.gif" alt="loaderblank" /><img style="display:none;" id="loader_<!--[$region.regionID]-->" src="images/loader.gif" alt="loaderblank" /></td>
        </tr>
      <!--[/foreach]-->
      </table>
	<!--[elseif $step eq 5]-->
    <h4>ADD an API Key</h4>
    <div class="mcenter txtcenter">
      <p>
        <a class="link" href="install.php?step=6" title="Finish Installation">Finish Installation</a>
      </p>
    </div>
    <div class="mcenter">
      <form method="post" action="install.php?action=getcharacters">
      <div>
        USERID: <input type="text" name="userid" size="10" /> APIKEY: <input type="text" name="apikey" size="35" /> <input type="submit" value="Select Character" />
      </div>
      </form>
      </div>
      <br /><br /><hr />
          <div class="mcenter">
      <div>
      <h4>Current API Keys</h4>
        <table class="tracktable" style="width:640px;">
        <thead>
          <tr>
            <th>Corp</th>
            <th>UserID</th>
            <th>API Key (first 5 characters)</th>
          </tr>
        </thead>
        <tbody>
        <!--[foreach item='key' from=$keys]-->
          <tr>
            <td><!--[$key.corp|default:"&nbsp;"]--></td>
            <td><!--[$key.userID|default:"&nbsp;"]--></td>
            <td><!--[$key.shortkey|default:"&nbsp;"]--></td>
           </tr>
        <!--[/foreach]-->
        </tbody>
        </table>
      </div>
      </form>
    
	<!--[/if]-->
	<!--[if $action eq 'getcharacters']-->
      <!--[foreach item='character' from=$characters]-->
      <!--[assign var='alliance' value=$character.alliance]-->
      <div style="margin-bottom:25px;">
      <form id="u_<!--[$character.characterID]-->" method="post" action="install.php">
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
    </div>
  </div>

<!--[include file='footer.tpl']-->