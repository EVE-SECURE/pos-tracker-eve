<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();


$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo',    $userinfo);
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array('1', $access) && !in_array('5', $access) && !in_array('6', $access)) {
		$eve->RedirectUrl('track.php');
}

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

	$mods = $posmgmt->GetAllPosMods($pos_id);
	if ($mods) {
    $current_pg  = 0;
    $current_cpu = 0;
    foreach($mods as $row) {
        if ($row['online']) {
            $current_pg  = $current_pg  + $row['pg'];
            $current_cpu = $current_cpu + $row['cpu'];
        }
    }
		$posmgmt->ChangeTowerCPUPG(array('pos_id' => $pos_id, 'new_pg' => $current_pg, 'new_cpu' => $current_cpu));
	}

    $eve->RedirectUrl('viewpos.php?i='.$pos_id);

}

$struct_amount = $eve->VarCleanFromInput('amount');


$eveRender->Assign('pos_id',  $pos_id);
$eveRender->Assign('structs', $structs);

$eveRender->Display('addstructures.tpl');
exit;
?>