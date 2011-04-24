<!--[include file='header.tpl']-->
  <form style="margin: 0pt; padding: 0pt;" method="post" action="jobs.php">
  
  <!--[if (in_array('41', $access)) || (in_array('45', $access)) || (in_array('5', $access))]-->
	
	<!--[if $completed != 1]-->
	<h3 class="pageTitle">Corporation Jobs Overview (Current Jobs)</h3>
	<input type="hidden" name="completed" value="1">
	<input type="submit" name="submit" value="Past Jobs" />
	<!--[else]-->
	<h3 class="pageTitle">Corporation Jobs Overview (Past Jobs)</h3>
	<input type="hidden" name="completed" value="0">
	<input type="submit" name="submit" value="Current Jobs" />
	<!--[/if]-->
	<!--[/if]-->
    <br>
	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="9"><center><b>Manufacturing</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Output Item</td>
	  <td class="txtcenter hcolor billheader">Runs</td>
	  <td class="txtcenter hcolor billheader">M.E.</td>
	  <td class="txtcenter hcolor billheader">P.E.</td>
	  <td class="txtcenter hcolor billheader">BPO/BPC</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 1 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$jobsID.outputTypeID]--></td>
	<td><!--[$jobsID.runs]--></td>
	<td><!--[$jobsID.installedItemMaterialLevel]--></td>
	<td><!--[$jobsID.installedItemProductivityLevel]--></td>
	<!--[if $jobsID.installedItemCopy == 0]-->
	<td>BPO</td>
	<!--[else]-->
	<td>BPC</td>
	<!--[/if]-->
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="9"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>

	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="7"><center><b>Time Efficiency Reseach</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Installed Item</td>
	  <td class="txtcenter hcolor billheader">Starting P.E.</td>
	  <td class="txtcenter hcolor billheader">Location</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 3 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$jobsID.installedItemTypeID]--></td>
	<td><!--[$jobsID.installedItemProductivityLevel]--></td>
	<td><!--[$jobsID.containerTypeID]--></td>
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="7"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>

	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="7"><center><b>Material Research</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Installed Item</td>
	  <td class="txtcenter hcolor billheader">Starting M.E.</td>
	  <td class="txtcenter hcolor billheader">Location</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 4 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$jobsID.installedItemTypeID]--></td>
	<td><!--[$jobsID.installedItemMaterialLevel]--></td>
	<td><!--[$jobsID.containerTypeID]--></td>
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="7"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>
	
	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="9"><center><b>Copying</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Installed Item</td>
	  <td class="txtcenter hcolor billheader">Copies</td>
	  <td class="txtcenter hcolor billheader">Production Runs</td>
	  <td class="txtcenter hcolor billheader">M.E.</td>
	  <td class="txtcenter hcolor billheader">P.E.</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 5 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$jobsID.installedItemTypeID]--></td>
	<td><!--[$jobsID.runs]--></td>
	<td><!--[$jobsID.licensedProductionRuns]--></td>
	<td><!--[$jobsID.installedItemMaterialLevel]--></td>
	<td><!--[$jobsID.installedItemProductivityLevel]--></td>
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="9"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>

	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="7"><center><b>Reverse Engineering</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Activity</td>
	  <td class="txtcenter hcolor billheader">Installed Item</td>
	  <td class="txtcenter hcolor billheader">BPO/BPC</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 7 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$activ.$job_activ]--></td>
	<td><!--[$jobsID.installedItemTypeID]--></td>
	<!--[if $jobsID.installedItemCopy == 0]-->
	<td>BPO</td>
	<!--[else]-->
	<td>BPC</td>
	<!--[/if]-->
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="7"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>

	<table class="mcenter tracktable" style="padding:0; width:70%;" cellspacing="1">
	<tbody>
	<tr><td colspan="8"><center><b>Invention</b></center></td></tr>
    <tr class="mbground">
	  <td class="txtcenter hcolor billheader">Job ID</td>
	  <td class="txtcenter hcolor billheader">Installed Item</td>
	  <td class="txtcenter hcolor billheader">Invented Item</td>
	  <td class="txtcenter hcolor billheader">Location</td>
	  <td class="txtcenter hcolor billheader">Installer</td>
      <td class="txtcenter hcolor billheader">Install Date</td>
      <td class="txtcenter hcolor billheader">End Date</td>
	  <td class="txtcenter hcolor billheader">Finishes</td>
    </tr>
	<!--[foreach item='jobsID' from=$jobs]-->
	<!--[assign var='job_activ' value=$jobsID.activityID]-->
	<!--[if $jobsID.activityID == 8 ]-->
	<td><!--[$jobsID.jobID]--></td>
	<td><!--[$jobsID.installedItemTypeID]--></td>
	<td><!--[$jobsID.outputTypeID]--></td>
	<td><!--[$jobsID.containerTypeID]--></td>	
	<td><!--[$jobsID.installerID]--></td>
	<td><!--[$jobsID.installTime]--></td>
	<td><!--[$jobsID.endProductionTime]--></td>
	<td>Hrmm</td>
	</tr>
	<!--[/if]-->
	<!--[/foreach]-->
	<br>
    <tr>
      <td colspan="8"><hr></td>
    </tr>
	</tbody>
	</table>
	<br><br>
</form>

<!--[include file='footer.tpl']-->
