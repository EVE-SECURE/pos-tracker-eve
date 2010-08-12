 <h3 class="txtcenter"><!--[$days_to_refuel]--> Moon Database</h3>
  <form style="text-align: center;" method="post" action="module.php?name=MoonDB&amp;func=AddNewMaterial">
  <div>
    <table cellspacing="0" class="mcenter" style="padding:5px; font:11px Arial, sans-serif;">
      <tr class="mbground">
        <td class="billheader hcolor">Region</td>
        <td class="billheader hcolor">System</td>
        <td class="billheader hcolor">Planet - Moon</td>
        <td class="billheader hcolor">Material</td>
        <td class="billheader hcolor">Abundance</td>
		<td class="billheader hcolor">Notes</td>
        <td class="billheader hcolor">Taken</td>
      </tr>
      <tr>
        <td class="billcontent">
          <select name="regionID" id="regionID" onchange="ajax_GetSystemList();">
          <!--[html_options options=$optregions selected=$regionID id='optregionID']-->
          </select>
        </td>
        <td class="billcontent">
          <select name="systemID" id="systemID" onchange="ajax_GetMoonList();">
          <!--[html_options options=$optsystems selected=$systemID id='optsystemID']-->
          </select>
        </td>
        <td class="billcontent">
          <select name="moonID" id="moonID"<!--[* onchange="ajax_GetMoonList();"*]-->>
          <!--[html_options options=$optmoons id='optmoonID']-->
          </select>
        </td>
        <td class="billcontent">
          <select name="material_id" id="material_id">
          <!--[html_options options=$optmaterials id='material_id']-->
          </select>
        </td>
        <td class="billcontent"><input type="text" name="abundance" value="Abundance" onfocus="clearText(this);" /></td>
        <td class="billcontent"><input type="text" name="notes" value="notes" onfocus="clearText(this);" /></td>
        <td class="billcontent"><input type="checkbox" name="taken" /></td>
      </tr>
      <tr>
        <td class="txtcenter" colspan="6"><hr /></td>
      </tr>
      <tr>
        <td class="txtcenter" colspan="6"><input type="submit" name="submit" value="Add" /></td>
      </tr>
    </table>
  </div>
  </form>
  <!--[*
  <form style="text-align: center;" method="post" name="filter" action="module.php?name=MoonDB">
  <div>
    <input type="hidden" name="func" value="filter" />
    <p style="text-align:center;">
      <select name="regionID" id="regionID" onchange="ajax_GetSystemList();">
      <!--[html_options options=$optregions selected=$regionID id='optregionID']-->
      </select>
      <select name="systemID" id="systemID" onchange="ajax_GetMoonList();">
      <!--[html_options options=$optsystems selected=$systemID id='optsystemID']-->
      </select>
      <select name="moonID" id="moonID">
      <!--[html_options options=$optmoons id='optmoonID']-->
      </select>
      <input type="submit" name="submit" value="Filter" /> - <a href="module.php?name=MoonDB" title="Clear Filter">Clear Filter</a>
    </p>
  </div>
  </form>
  *]-->
  <table cellspacing="0" class="mcenter" style="width:90%; padding:5px; font:11px Arial, sans-serif;">
    <tr class="mbground">
      <td class="billheader hcolor">Region</td>
      <td class="billheader hcolor">System</td>
      <td class="billheader hcolor">Moon</td>
      <td class="billheader hcolor">Material</td>
      <td class="billheader hcolor">Abundance</td>
	  <td class="billheader hcolor">Notes</td>
      <td class="billheader hcolor">Taken</td>
    </tr>
  <!--[foreach item='row' from=$rows]-->
    <tr>
      <td class="billcontent"><!--[$row.regionName]--></td>
      <td class="billcontent"><!--[$row.systemName]--></td>
      <td class="billcontent"><!--[$row.moonName]--></td>
      <td class="billcontent"><!--[$row.material_name]--></td>
      <td class="billcontent"><!--[$row.abundance]--></td>
      <td class="billcontent"><!--[$row.notes|escape:'htmlall']--></td>
      <td class="billcontent"><!--[if $row.taken]-->Yes<!--[else]-->No<!--[/if]--></td>
    </tr>
  <!--[/foreach]-->
  </table>
  <p class="mcenter"><a class="link" href="module.php?name=MoonDB&amp;func=AddNew" title="Add new material">Add a new material</a></p>
