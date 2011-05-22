<!--[include file='header.tpl']-->

  <h2>Welcome to the POS Tracker FGV</h2>
  <div class="mcenter txtleft">
    <h3>POS-Tracker Version: (<!--[$version]-->)</h3>
    <span class="txtleft">Interactive Player Owned Starbase Tracking and Management Website. Compatible both in game and out of game.</span>
    <br />
	<br />
	<strong>Version 5.1.1 Beta 2 to 5.1.2 Changes:</strong>
    <ul>
	  <li>Fuel Bill now has Prices! Prices can be changed via the Admin Panel. DB Upgrade Required.</li>
	  <li>SubAdmin permissions can now be given by the Admin account.</li>
	  <li>Past Jobs Installer IDs got a small fix so they wouldn't all appear as ----.</li>
	  <li>X-Large Ship Assembly Array is now selectable under modules. After doing the DB upgrade any Large Ship Assembly Arrays will become X-Large due to ID conflict from original POS Tracker code.</li>
	  <li>Fixed bug not allowing you to see past page 1 on the POS Track page.</li>
	</ul>
    <br />
	<strong>Version 5.1.1 Beta 1 to 5.1.1 Beta 2 Changes:</strong>
    <ul>
	  <li>Subdomain Bug Fixed.</li>
	  <li>API Pulls now done via HTTPS/SSL.</li>
	  <li>Isotope type for tower now shown on View and Edit POS pages.</li>
	  <li>Fixed version checker typo that made it work backwards.</li>
	  <li>Industrial Job API Timer Fixed.</li>
	  <li>Past Industrial Jobs now selectable if you have the rights - May take a few minutes to load depending on how many jobs you have loaded into the DB.</li>
	  <li>Industrial Jobs installer IDs now show if the manufacturer is loaded into the tracker.</li>
	  <li>View and Edit POS pages now correctly show amounts in silos instead of m3.</li>
	  <li>Production input silos can no longer go negative.</li>
	</ul>
    <br />
	<strong>Version 5.0.4 to 5.1.1 Beta 1 Changes:</strong>
    <ul>
	  <li>Complete re-write of the POS-Tracker's access system. Administrators/CEOs now have far greater control of what a user can and cannot do in the tracker.</li>
	  <li>Corporation Jobs Added.</li>
	  <li>Charters now have optimal correctly.</li>
	  <li>Fixed Session Security Hole.</li>
	  <li>Admin page now checks for install.php which should be removed/renamed for security reasons after installation is complete.</li>
	  <li>Fixed Show Stront Timers from accidentally showing while sorting POS Track listing.</li>
	  <li>Mailer updated to NOT email about towers in "Unanchored" or "Anchored" status. It will spam on all other statuses.</li>
	  <li>Directions added for Updating Corp/Alliance on User Page. Page needs to be trusted otherwise corp gets set to null.</li>
	  <li>Central Version File Added.</li>
	  <li>Version check added on Admin Panel.</li>
	  <li>Help page added which is accessable in the footer. Will be adding to this over time.</li>
	  <li>Tracker now properly supports multiple corporations.</li>
	  <li>Missing Session Variable Added. - Thx Salvoxia</li>
	</ul>
    <br />
	<strong>Version 5.0.3 to 5.0.4 Changes:</strong>
    <ul>
      <li>Updated access for mailer. Due to added security changes, the mailer program lost access to check towers correctly in some cases.</li>
	  <li>posmail.sh file added to help people utilize the mailer program. Recommend cron job runs every 12 hours.</li>
	  <li>Fixed viewpos.tpl typo. - Thx Donna Vecchi</li>
	  <li>Tyrannis change added. Removed charters requirement from 0.4 systems. Towers already within the program will have to removed and readded to reflect the change or manual DB update for charters_needed on the tower needs to be set to 0. </li>
	  <li>Production page now has one update button to update all rows at once based on what's changed.</li>
	  <li>Production page now has full on security. (e.g. If a fuel tech you can only see your tower's production.)</li>
	</ul>
    <br />
	<strong>Version 5.0.2 to 5.0.3 Changes:</strong>
    <ul>
      <li>Fuel Calculator bug fixed where days didn't affect the amount of fuel needed.</li>
	  <li>Fuel Calculator options current levels and optimal levels are now set to on by default.</li>
    </ul>
    <br />
	<strong>Version 5.0.1 to 5.0.2 Changes:</strong>
    <ul>
      <li>Fuel Bill layout now matches what is shown while viewing towers to make it easier to look between the two.</li>
	  <li>Fuel Calculator now allows you to show the optimal fuel levels and see what's required to match the optimal. Hauling trips included.</li>
	  <li>Fuel Calculator's "Use Current Level" stays to what you set it at while on the page as opposed to being turned back "on" after looking up a tower. Default is now off due to change.</li>
	  <li>Fuel Bill now displays optimal fueling by default(new option) as it makes far more sense than selecting days that may not be reachable by all POS towers. Please note that when optimal is on, days filter does not take effect at all.</li>
	  <li>Massive style coding cleanup(CSS file now 1/3rd the size it used to be and pages are much more CSS clean).</li>
	  <li>Fixed Secretive POS problem not showing towers for directors.</li>
	  <li>Fixed write/config greyed out bug for new installs that would happen based on server configurations.</li>
	  <li>Themes! - The FGV Theme will be default but the old theme and a few others are now available for each user under the user panel. (Requires DB Update)</li>
	  <li>Tower name is now shown on the fuel bill.</li>
    </ul>
    <br />
    <strong>Version 3.0 to 5.0.1 Changes:</strong>
    <ul>
      <li>Changed version numbering scheme due to confusion with other people's version and mine. We are now on version 5 because 5 is an awesome number.</li>
      <li>Added Secret POS feature. People who are allowed to see the Secret POSes are people who are deemed "Highly Trusted" or if they are fuel techs of the tower. The only one that can change "secretive" status of a tower is the default admin account. Functionality added under the edit POS area.</li>
      <li>Implemented several security checks to stop low access accounts see or do what they shouldn't be able to.</li>
	  <li>Added Stront Timer option on the pos track page.</li>
	  <li>Material Volume updates for: Atmospheric Gases, Caesium, Crystalline Carbonide, Evaporite Deposits, Fernite Carbide, Hydrocarbons, Silicates, Sylramic Fibers, and Titanium Carbide. (Requires a DB update)</li>
    </ul>
    <br />
    <strong>Version 3.0 ( <a href="#" onclick="CCPEVE.showInfo(1377, 772034121)">Frozen Guardian</a> Version)</strong><br />
    <br />
    <br />
    <b>Original 3.0 Version to FGV</b><br />
    <ul>
    <li>New Theme.</li>
    <li>Updated m3 values to match EVE Tyrannis Expansion.</li>
    <li>pos_val.php added to control m3 values if they ever were to be changed again by CCP instead of manually updating 64+ value locations in the code.</li>
    <li>Optimal is calculated correctly now on both the POS view and edit pages. </li>
    <li>Difference is calculated correctly now on both the POS view and edit pages.</li>
    <li>"Available" on POS page now shows what's actually in the database(API should be updated via CRON or manually before making fuel runs/changes to make sure values match what's currently on Tranquility).</li>
    <li>Online time is now shown accurately and will still countdown the right time even if the API or Tower is not updated.</li>
    <li>Fuel Calculator and Fuel Bill updated to new m3 values.</li>
    <li>Liquid Ozone and Heavy Water calculated correctly for POS with sovereign status. (This requires a DB update.)</li>
    <li>Total Difference in m3 added in the POS view page to help fuel techs know how much space will be taken on fueling the tower(does not add Strontium Calthrates to the total).</li>
    <li>Removed code from the design layout pages and linked back to the actual code to pull data.</li>
    <li>Several commented code and redundant functions removed making this POS Tracker a better tool for us all.</li>
    </ul> <br />
    
	<strong>Major features:</strong>
    <ul>
      <li>POS Fuel Tracking with Uptime Calculations</li>
      <li>Outpost Fuel Tracking with Uptime Calculations</li>
      <li>AutoSov<sup>&copy;</sup> Sovereignty tracking with automatic fuel usage updates (CRON)</li>
      <li>Absolute Location System</li>
      <li>Moon Mining and Reaction Tracking as well as Silo Tracking</li>
    </ul>
    <br />
    <strong>Version 3.0 and down</strong><br />
    Templating and Adodb as well as some structure done by DeTox MinRohim
    Designed by: <a href="showinfo:1373//716293725">MrRx7</a> and <a href="showinfo:1376//274699092">Johnathan Roark</a>
    <br />
    Based on code By: <a href="showinfo:1373//1184523901">Utoxin</a>, <a href="showinfo:1377//1326175604">Esaam DeVries</a>, and <a href="showinfo:1377//1617746019">Nina Mires</a>
    <br /><br />
    Special thanks to:<br />
    Abdool<br />
    Dark Blossom<br />
    Kahlil Dass<br />
    franny<br />
    SigmaPi<br />
    TenthReality S. Preston<br />
    Esquire
    and test bong<br />
  Icons by <a href="http://www.famfamfam.com/">www.famfamfam.com</a></div><br>
<!--[include file='footer.tpl']-->