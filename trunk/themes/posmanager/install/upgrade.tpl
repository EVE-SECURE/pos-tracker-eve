<!--[include file='install/install_header.tpl']-->

  <div class="mcenter">
    <div class="mcolor txtleft">
    <!--[if $step eq 1]-->
	Please Select the upgrade you need to apply:
	<form method="post" action="upgrade.php?step=2">
	<!--[html_options options=$upgradeList name='upgrade']-->
	<input type="submit" name="action" value="Next" />
	<!--[/if]-->
	<!--[if $step eq 2]-->
	<strong>Upgrade Complete</strong><br>
	Please Select the upgrade you need to apply:
	<form method="post" action="upgrade.php?step=2">
	<!--[html_options options=$upgradeList name='upgrade']-->
	<input type="submit" name="action" value="Next" />
	<!--[/if]-->