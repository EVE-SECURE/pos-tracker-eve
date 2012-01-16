<!--[include file='header.tpl']-->

  <h2>POS Tracker FGV - Help Center</h2>
  <hr>
  <div class="mcenter txtleft">
    <h3><u>User Help:</u></h3>
	<ul>
			<li>Why can't I login after registering my account?<ul><li>After registering your administrator needs to give you access before you can actually log in.</li></ul></li>
			<li>Where is the Max Days option for fueling towers?<ul><li>Within the POS Tracker (Optimal = Max Amount) of days you can possibly get. Optimal will make sure you fill the tower up to the max amount you can in the fuel bay.</li></ul></li>
	</ul>
	<hr>
	
	<h3><u>Administrator Help:</u></h3>
	<b><u>Installer</u></b> - You must meet all installer requirements otherwise the POS Tracker may not work.<BR><BR>
	<b>Installer Requirements:
	<ul>
	<li>MySQL DB</li>
	<li>PHP Version: 5.1.2+</li>
	<li>CURL Version: 7.21.0+</li>
	<li>Required Modules Needed: CURL, SimpleXML, Hash</b></li>
	<li><b>Register_globals</b> needs to be <b>off</b>. If you see "Register_globals: On or Register_globals: >blank<" you have register globals on. </li>
	</ul>
	<BR>

	<b><u>Access Details</u></b> - When you give someone more access by selecting further down on the drop down menus, they inherit all the above permissions. So selecting "Secret" under Corp also means they can view and edit normal towers.
	<ul>
		<li><b><u>Corp</u></b>
			<ul>
				<li><b>No Access</b> - Can not view any towers of the corporation they are a user of. Can still view/edit if they are a fuel tech of the tower.</li>
				<li><b>View</b> - Can view all towers(excluding secret towers) of the corporation that user is part of.</li>
				<li><b>Edit</b> - Can view and edit all towers(excluding secret towers) of the corporation that user is part of.</li>
				<li><b>Secret</b> - Can view and edit all towers including secret towers of the corporation that user is part of.</li>
			</ul>
		</li>
		<li><b><u>Other Corps</u></b>
			<ul>
				<li><b>No Access</b> - Can not view any towers of other corporations setup in the POS Tracker. Can still view/edit if they are a fuel tech of the tower.</li>
				<li><b>View</b> - Can view all towers(excluding secret towers) of other corporations setup in the POS Tracker.</li>
				<li><b>Edit</b> - Can view and edit all towers(excluding secret towers) of other corporations setup in the POS Tracker.</li>
				<li><b>Secret</b> - Can view and edit all towers including secret towers of other corporations setup in the POS Tracker.</li>
			</ul>
		</li>
		<li><b><u>Jobs</u></b> - This security unfortuantely doesn't work like it should. Unless you trust someone to see all Jobs, set their access to No Access.
			<ul>
				<li><b>No Access</b> - Can not view any industrial jobs.</li>
				<li><b>Current</b> - Can view all current industrial jobs of the corporation that user is part of.</li>
				<li><b>Past</b> - Can view all past industrial jobs of the corporation that user is part of.</li>
				<li><b>All Corps</b> - Can view all current industrial jobs imported into the POS Tracker.</li>
			</ul>
		</li>
		<li><b><u>Production</u></b> - (Note: Production will only show if they have access to the tower. More details below.)
			<ul>
				<li><b>No Access</b> - Can not view any production.</li>
				<li><b>Own</b> - Can view/edit any production that is setup on towers where they are a fuel tech.</li>
				<li><b>Same Corp</b> - Can view/edit any production that is setup on towers for the corporation that user is part of.</li>
				<li><b>All Corps</b> - Can view/edit any production that is setup in POS Tracker.</li>
			</ul>
		</li>
		<li><b><u>ReStocker</u></b>
			<ul>
				<li><b>N/A</b> - Currently not implemented.</li>
			</ul>
		</li>
		<li><b><u>Trusted</u></b>
			<ul>
				<li><b>When Checked</b> - User is able to add towers manually and can delete towers where they are a fuel tech.</li>
			</ul>
		</li>
		<li><b><u>SubAdmin</u></b>
			<ul>
				<li><b>When Checked</b> - Has the same abilities as the admin account except it can't modify other SubAdmin accounts, remove API keys, or remove other user accounts. They will be able to disable other accounts just not remove. All other permission selections will become disabled for this account.</li>
			</ul>
		</li>
		<li><b><u>Enabled</u></b>
			<ul>
				<li><b>When Checked</b> - User account is able to login to the POS Tracker </li>
			</ul>
		</li>
		<li><font color="red"><b><u>Remove</u></b></font>
			<ul>
				<li><b>When Checked</b> - Will <font color="red">remove</font> the selected user from the POS Tracker completely. Can not be undone.</li>
			</ul>
		</li>
	</ul>

	<br>
<b>Production Permissions:</b> In order for a person to see production setup on a tower they must have access to that tower in one way shape or form. Below are examples of the permissions needed for certain setups for users.<br><br>
<b>Production Setup - (Access needed to view and edit production on that tower):</b>
	<ul>
		<li>User is a fuel tech on any type of tower setup - (Production: Own)</li>
		<li>User is not a fuel tech but a member of that corp on a non secret tower - (Corp: View, Edit, or Secret | Production: Same Corp)</li>
		<li>User is not a fuel tech but a member of that corp on a secret tower - (Corp: Secret | Production: Same Corp)</li>
		<li>User is not a fuel tech and not a member of that corp on a secret tower - (Other Corp: Secret | Production: All Corps)</li>
		<li>Allow user to view all production within the POS Tracker - (Corp: Secret | Other Corp: Secret | Production: All Corps)</li>
	</ul>
<BR>
<b><u>Common Errors/Fixes/FAQ</u></b>
	<ul>
			<li>Fatal error: Call to undefined function ADONewConnection() in /pos/includes/dbfunctions.php on line 71<ul><li>You get this error when trying to run the POS Tracker or page in PHP4. If this happens during a Cron Job run, make sure that the job points to your PHP5 install on the server.</li></ul> </li>
			<li>API Imported tower doesn't have a location.<ul><li>You will need to make sure the Region is installed under the Moon Database with the Admin Panel.</li></ul></li>
			<li>Sov incorrect since I changed/joined an Alliance. How do I update my towers to have the correct Sov?<ul><li>The tower alliance information is now based off the API key so just remake the API key to make sure your new joined alliance shows up under the admin panel.</li></ul></li>
			<li>EVE-Marketdata imported prices won't update on the global price list.<ul><li>EVE-Marketdata currently has a 24 hour cache which is updated at downtime so wait until the the next downtime.</li></ul></li>
			<li>Can I setup a daily API pull for the global price list like to EVE-Marketdata?<ul><li>At this time no, however it is in the works along with some other possible sites.</li></ul></li>
			<li>My POS Track page isn't sorting/displaying by what shows under my user panel(10 & Corp A).<ul><li>Most likely this is the first time you've logged in since the new version, click Update Settings under your user panel and everything should work wonderfully.</li></ul></li>
			<li>Why is ViewPOS different than Fuel Bill if API isn't pulling in every hour?<ul><li>On ViewPOS only the Online section counts down. Available and Optimal are going off what's actually stored in the database.</li><li>On Fuel Bill the optimal works just like ViewPOS except it also counts in how many hours ago the POS was updated.</li><li>If you have the API pull in more often the pages will matchup.</li></ul></li>
	</ul>	
</div>
	
	
<!--[include file='footer.tpl']-->