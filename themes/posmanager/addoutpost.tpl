<!--[* $Id: addoutpost.tpl 217 2008-12-15 12:12:43Z eveoneway $ *]-->
<!--[include file='header.tpl']-->

  <h3>Add a New Outpost</h3>
  <div class="mcenter">
 <form method="post" action="addoutpost.php">
    <div>
      <table class="tracktable mcenter txtright" style="width:400px;">
        <tr>
          <td class="trackheader txtleft">Outpost Name:</td>
          <td><input name="outpostName" size="20" type="text" value="" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Enriched Uranium</td>
          <td><input name="uranium" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Oxygen</td>
          <td><input name="oxygen" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Mechanical Parts</td>
          <td><input name="mechanical_parts" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Coolant</td>
          <td><input name="coolant" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Robotics</td>
          <td><input name="robotics" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Helium Isotopes</td>
          <td><input name="heisotope" size="20" type="text" value="0" /></td>
        </tr>
            <tr>
          <td class="trackheader txtleft">Hydrogen Isotopes</td>
          <td><input name="hyisotope" size="20" type="text" value="0" /></td>
        </tr>
            <tr>
          <td class="trackheader txtleft">Oxygen Isotopes</td>
          <td><input name="oxisotope" size="20" type="text" value="0" /></td>
        </tr>
            <tr>
          <td class="trackheader txtleft">Nitrogen Isotopes</td>
          <td><input name="niisotope" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Liquid Ozone</td>
          <td><input name="ozone" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Heavy Water</td>
          <td><input name="heavy_water" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Strontium Calthrates</td>
          <td><input name="strontium" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="trackheader txtleft">Charters</td>
          <td><input name="charters" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input type="submit" name="action" value="Add Outpost" /></td>
        </tr>
      </table>
    </div>
    </form>
  </div>