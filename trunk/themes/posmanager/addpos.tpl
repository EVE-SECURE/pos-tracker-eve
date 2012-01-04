<!--[* $Id: addpos.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->

  <h3>Add a New Tower</h3>
  <div class="mcenter">
  <!--[if $step eq 1]-->
    <form method="post" action="addpos.php">
    <div>
      <input name="step" value="<!--[math equation='x+1' x=$step]-->" type="hidden" />
      <table class="tracktable mcenter txtleft">
        <tr>
          <td class="mbground hcolor">Select Region:</td>
          <td><!--[html_options name='regionID' options=$arrregions]--></td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="NEXT" /></td>
        </tr>
      </table>
    </div>
    </form>
  <!--[elseif $step eq 2]-->
    <form method="post" action="addpos.php">
    <div>
      <input name="step" value="<!--[math equation='x+1' x=$step]-->" type="hidden" />
      <input name="regionID" value="<!--[$regionID]-->" type="hidden" />
      <table class="tracktable mcenter txtleft">
        <tr>
          <td class="mbground hcolor">Select Constellation:</td>
          <td><!--[html_options name='constellationID' options=$arrconstellation]--></td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="NEXT" /></td>
        </tr>
      </table>
    </div>
    </form>
  <!--[elseif $step eq 3]-->
    <form method="post" action="addpos.php">
    <div>
      <input name="step" value="<!--[math equation='x+1' x=$step]-->" type="hidden" />
      <input name="regionID" value="<!--[$regionID]-->" type="hidden" />
      <input name="constellationID" value="<!--[$constellationID]-->" type="hidden" />
      <table class="tracktable mcenter txtleft">
        <tr>
          <td class="mbground hcolor">Select System:</td>
          <td><!--[html_options name='solarSystemID' options=$arrsystems]--></td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="NEXT" /></td>
        </tr>
      </table>
    </div>
    </form>
  <!--[elseif $step eq 4]-->
    <form method="post" action="addpos.php">
    <div>
      <input name="step" value="<!--[math equation='x+1' x=$step]-->" type="hidden" />
      <input name="regionID" value="<!--[$regionID]-->" type="hidden" />
      <input name="solarSystemID" value="<!--[$solarSystemID]-->" type="hidden" />
      <input name="constellationID" value="<!--[$constellationID]-->" type="hidden" />
      <table class="tracktable mcenter txtleft">
        <tr>
          <td class="mbground hcolor">Select Moon:</td>
          <td><!--[html_options name='moonID' options=$arrmoons]--></td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="NEXT" /></td>
        </tr>
      </table>
    </div>
    </form>
  <!--[elseif $step eq 5]-->
    <form method="post" action="addpos.php">
    <div>
      <input name="step" value="<!--[math equation='x+1' x=$step]-->" type="hidden" />
      <input name="moonID" value="<!--[$moonID]-->" type="hidden" />
      <input name="regionID" value="<!--[$regionID]-->" type="hidden" />
      <input name="solarSystemID" value="<!--[$solarSystemID]-->" type="hidden" />
      <input name="constellationID" value="<!--[$constellationID]-->" type="hidden" />
      <table class="tracktable mcenter txtright" style="width:400px;">
        <tr>
          <td class="txtleft mbground hcolor">Size:</td>
          <td><!--[html_options name='pos_size' options=$arrposize]--></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Race:</td>
          <td><!--[html_options name='pos_race' options=$arrporace]--></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Tower Name:</td>
          <td><input name="towerName" size="20" type="text" value="" /></td>
        </tr>
        <!--[*<tr>
          <td class="txtleft mbground hcolor">Sovereignity:</td>
          <td><input name="sovereignity" type="checkbox" /></td>
        </tr>*]-->
        <tr>
          <td class="txtleft mbground hcolor">Enriched Uranium</td>
          <td><input name="uranium" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Oxygen</td>
          <td><input name="oxygen" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Mechanical Parts</td>
          <td><input name="mechanical_parts" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Coolant</td>
          <td><input name="coolant" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Robotics</td>
          <td><input name="robotics" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Isotopes</td>
          <td><input name="isotope" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Liquid Ozone</td>
          <td><input name="ozone" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Heavy Water</td>
          <td><input name="heavy_water" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Strontium Calthrates</td>
          <td><input name="strontium" size="20" type="text" value="0" /></td>
        </tr>
        <tr>
          <td class="txtleft mbground hcolor">Status:</td>
          <td>
            <select name="status">
              <option value="0"></option>
              <option value="4">Online</option>
              <option value="1">Offline</option>
              <option value="3">Reinforced</option>
              <!--<option value="3">War fuel mode</option>
              <option value="4">Template</option>
              <option value="5">Research</option>
              <option value="6">Cyno</option>-->
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="txtcenter"><input class="mButton" type="submit" value="Add Structures" /></td>
        </tr>
      </table>
    </div>
    </form>
  <!--[/if]-->
  </div>



<!--[include file='footer.tpl']-->