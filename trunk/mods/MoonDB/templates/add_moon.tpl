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

