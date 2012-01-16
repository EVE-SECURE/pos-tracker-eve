<!--[include file='header.tpl']-->
  <h2>Region Administration</h2>
  <div class="mcenter txtcenter">
    <p>
      <a class="link" href="admin.php" title="Finish Installation">Done</a>
    </p>
  </div>
  <table class="tracktable mcenter">
    <tr class="mbground hcolor">
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
      <td style="width:125px;"><button class="mButton" type="button" id="region_<!--[$region.regionID]-->" onclick="ajax_InstallRegion(<!--[$region.regionID]-->);"><!--[if $region.installed]-->Uninstall<!--[else]-->Install<!--[/if]--></button>&nbsp;&nbsp;<img id="loaderblank_<!--[$region.regionID]-->" src="images/loader.blank.black.gif" alt="loaderblank" /><img style="display:none;" id="loader_<!--[$region.regionID]-->" src="images/loader.gif" alt="loaderblank" /></td>
    </tr>
  <!--[/foreach]-->
  </table>


<!--[include file='footer.tpl']-->