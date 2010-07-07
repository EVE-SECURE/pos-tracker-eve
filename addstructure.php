<?php
/**
 * Pos-Tracker2
 *
 * Starbase structure add
 *
 * PHP version 5
 *
 * LICENSE: This file is part of POS-Tracker2.
 * POS-Tracker2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * POS-Tracker2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with POS-Tracker2.  If not, see <http://www.gnu.org/licenses/>.
 *

 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @author      Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2007-2009 (C)  Stephen Gulick, DeTox MinRohim, and Andy Snowden
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    POS-Tracker2
 * @version    SVN: $Id: addstructure.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();


$access = $eve->SessionGetVar('access');

if ($access < 2) {
    $eve->RedirectUrl('login.php');
}

$eveRender->Assign('access', $access);

$pos_id = $eve->VarCleanFromInput('i');
if (empty($pos_id)) {
    $pos_id = $eve->VarCleanFromInput('pos_id');
    if (empty($pos_id)) {
        $eve->SessionSetVar('errormsg', 'No ID defined!');
        $eve->RedirectUrl('track.php');
    }
}


$structs = $posmgmt->GetAllStaticStructures2();

$action = $eve->VarCleanFromInput('action');

if ($action == 'Done') {

    $dbconn  =& DBGetConn(true);

    foreach ($structs as $struct) {
        $structvalue = $eve->VarCleanFromInput('s_id'.$struct['id']);
        if ($structvalue != 0) {
            for ($x = 1;$x<=$structvalue;$x++) {
                $structures[] = $struct['id'];
            }
        }
    }
    $n = count($structures);

    foreach($structures as $struc) {
        $s_id = $struc;//$_POST['s_id' . $n];

        if ($s_id >= "1") {
            $nextId = $dbconn->GenId(TBL_PREFIX.'pos_structures');

            $sql = "INSERT INTO ".TBL_PREFIX."pos_structures VALUES ('".$eve->VarPrepForStore($nextId)."', '" . $eve->VarPrepForStore((int)$pos_id) . "', '" . $eve->VarPrepForStore($s_id) . "', 1)";
            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                echo 'That doesnt work; ' . $dbconn->ErrorMsg();
                return false;
            }
            $newId = $dbconn->PO_Insert_ID(TBL_PREFIX.'pos_structures', 'id');

            $time = time();
            if ($s_id == 17621) {
                $hangar_id = $newId;//mysql_insert_id();
                $sql = "INSERT INTO ".TBL_PREFIX."pos_hanger VALUES ('{$hangar_id}','" . $pos_id . "','0','0','0','0','0','0','0','0','0','0')";
                mysql_query($sql);
                $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES ('NULL', '" . $eve->VarPrepForStore($eve_id) . "', '" . $eve->VarPrepForStore($hangar_id) . "', '3', 'Add Hanger', '" . $time . "')";
                $result = mysql_query($sql) or die('Could not insert values into update_log; ' . mysql_error());
            }
            if ($s_id == 14343) {
                $silo_id = $newId;//mysql_insert_id();
                //echo ''.$s_id.'-'.$silo_id; exit;
                //$sql = "INSERT INTO ".TBL_PREFIX."silo_info VALUES ('{$silo_id}','" . $eve->VarPrepForStore($pos_id) . "','14343','0','0','0','0','0')";
                $sql = "INSERT INTO ".TBL_PREFIX."silo_info VALUES ('".$eve->VarPrepForStore($silo_id)."','" . $eve->VarPrepForStore($pos_id) . "','14343','0','0','0','0','0','0')";
                $dbconn->Execute($sql);
                //mysql_query($sql);
                $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES ('NULL', '1', '" . $eve->VarPrepForStore($silo_id) . "', '2', 'Add Silo', '" . $time . "')";
                $result = mysql_query($sql) or die('Could not insert values into update_log; ' . mysql_error());
            }
            if ($s_id == 16221 || $s_id==17170 || $s_id==20175 || $s_id==16869) {
                $structure_id = mysql_insert_id();
                $sql = "INSERT INTO ".TBL_PREFIX."reactor_info VALUES ('{$structure_id}','" . $eve->VarPrepForStore($pos_id) . "','".$s_id."','0')";
                $dbconn->Execute($sql);
                $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES ('NULL', '" . $eve_id . "', '" . $eve->VarPrepForStore($silo_id) . "', '2', 'Add Harvester/Reactor', '" . $time . "')";
                $result = mysql_query($sql)
                  or die('Could not insert values into update_log; ' . mysql_error());
            }
        }
    }

    $eve->RedirectUrl('viewpos.php?i='.$pos_id);

}

$struct_amount = $eve->VarCleanFromInput('amount');


$eveRender->Assign('pos_id',  $pos_id);
$eveRender->Assign('structs', $structs);

$eveRender->Display('addstructures.tpl');
exit;

/*
echo "<form method=\"post\" action=\"pos-transaction.php\">\n";
echo "<input name=\"pos_id\" value=\"".$pos_id."\" type=\"hidden\">\n";
echo "<input name=\"amount\" value=\"".$struct_amount."\" type=\"hidden\">\n";
echo "<table>\n";
foreach($structs as $structure) {
    echo "  <tr>\n";
    echo "    <td>".$structure['name']."</td>\n";
    echo "    <td><input type=\"text\" size=\"5\" name=\"s_id".$structure['id']."\" value=\"0\" /></td>\n";
    echo "  </tr>\n";
}
echo "  <tr><td><hr /></td></tr>\n";
echo "  <tr>\n";
echo "    <td><input type=\"submit\" name=\"action\" value=\"Done\"></td>\n";
echo "  </tr>\n";
echo "</table>\n";

require_once 'footer.php';*/
?>