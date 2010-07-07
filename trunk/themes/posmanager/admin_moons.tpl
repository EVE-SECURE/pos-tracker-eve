<!--[* $Id: admin_moons.tpl 177 2008-09-28 20:42:42Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <h2>Administration</h2>
  <div class="mcenter txtcenter">
    <p>
      <a class="arialwhite14 txtunderlined" href="admin.php" title="Finish Installation">Done</a>
    </p>
  </div>
  <table class="tracktable mcenter" style="font-size:11px; font-family: Arial, sans-serif;">
    <tr style="background-color:#4F0202;">
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


<!--[include file='footer.tpl']-->