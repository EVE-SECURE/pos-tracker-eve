<!--[include file='header.tpl']-->

  <h2>Welcome to the POS Tracker</h2>
  <div class="mcenter txtleft">
    <h3>POS-Tracker Version: (<!--[$version]-->)</h3>
    <span class="txtleft">Interactive Player Owned Starbase Tracking and Management Website. Compatible both in game and out of game.</span>
    <br /><br />
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