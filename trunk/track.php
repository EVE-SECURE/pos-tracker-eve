<?php

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, '', false);
$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$eveRender->Assign('name', $userinfo['name']);
$eveRender->Assign('corp', $userinfo['corp']);

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);

$pID = 'track';
$eveRender->Assign('pID', $pID);

include_once 'themes/posmanager/style/theme'.$theme_id.'.php';

$user_track = explode('.',$userinfo['user_track']);

if (in_array('1', $access) || in_array('5', $access) || in_array('6', $access)) {

            //sets current time
            $time = time();

            //pulls time out of database for last update
            $pulltime = $posmgmt->GetLastSystemUpdate();

            $sovtime = $posmgmt->get_formatted_timediff($pulltime, $now = false);
            //gives a difference value for the warning message
            $sovtimedifference = $time - $pulltime;

            //pulls time out of database for last update for ally
            $pulltimeally = $posmgmt->GetLastAllianceUpdate();

            $allytime = $posmgmt->get_formatted_timediff($pulltimeally, $now = false);
            //gives a difference value for the warning message
            $allytimedifference = $time - $pulltimeally;
            if ($sovtimedifference >= "86400" && (in_array('5', $access) || in_array('6', $access))) { //1 day
                $errormsg = '<b>Warning, Your Sovereignty data is out of date.</b> ' . $sovtime . '<br />';

            }
            if ($allytimedifference >= "604800" && (in_array('5', $access) || in_array('6', $access))) {  #1 week
                $errormsg .= 'Warning, Your Alliance data is out of date. ' . $allytime . '<br />';
            }
            if ($errormsg) {
                $eve->SessionSetVar('errormsg', $errormsg);
            }

	$sb = $eve->VarCleanFromInput('sb');
	if (!empty($sb)) {
		$user_track[1] = $sb;
	}
	
	$sd = $eve->VarCleanFromInput('sd');
	$sdd = $eve->SessionGetVar('sdd');
	
	if (!empty($sd)) {
		$user_track[0] = $sd;
		$eve->SessionSetVar('sdd',$sd);
	} elseif (!empty($sdd)) {
		$user_track[0] = $sdd;
	}
	
	$st = $eve->VarCleanFromInput('st');
	if (!empty($st)) {
		if ($st == 1) {
		$eve->SessionSetVar('st',$st);
		} elseif ($st == 2) {
		$eve->SessionSetVar('st',$st);
		}
	} else {
		$st = $eve->SessionGetVar('st');
	}
	
	$args['sb'] = $user_track[1];
	$args['limit'] = $user_track[0];
    $args['page']  = $eve->VarCleanFromInput('page');
    $args['startnum'] = $eve->VarCleanFromInput('startnum');

    $rows       = $posmgmt->GetAllPos2($args);
	$rows2       = $posmgmt->GetAllPos2();
    $towercount = count($rows2);

    $bgcolor   = "#111111";
    $textcolor = "#FFFFFF";

    foreach($rows as $key => $row) {
	
        $row2 = $posmgmt->GetLastPosUpdate($row['pos_id']);

/*0 - Unanchored (also unanchoring??) (has valid stateTimestamp)
Note that moonID is zero for unanchored Towers, but locationID will still yield the solar system ID
1 - Anchored / Offline (no time information stored)
2 - Onlining (will be online at time = onlineTimestamp)
3 - Reinforced (until time = stateTimestamp)
4 - Online (continuously since time = onlineTimestamp)*/

        if ($row['pos_status'] <= 2) {
            $row['pos_status_img'] = "offline.gif";
        } elseif ($row['pos_status'] == 3) {
            $row['pos_status_img'] = "reinforced.gif";
        } else {
            $row['pos_status_img'] = "online.gif";
        }

        if ($row['owner_id'] == $userinfo['eve_id'] || $row['secondary_owner_id'] == $userinfo['eve_id']) {
            $row['bgcolor']   = $colors['owner_background_color'];
            $row['textcolor'] = $colors['owner_text_color'];
        }

        if ( isset($_GET['highlight']) && ($_GET['highlight'] == $row['pos_id']) ) {
            $row['bgcolor']   = $colors['edited_background_color'];
            $row['textcolor'] = $colors['edited_text_color'];
        }

        if ( isset($focus_fuel) && $row['result_online'] <= $focus_fuel) {
            $row['bgcolor']   = $colors['focus_fuel_background_color'];
            $row['textcolor'] = $colors['focus_fuel_font_color'];
        }

        if ($row['result_online'] <= $minimal_fuel) {
            $row['bgcolor']   = $colors['minimal_fuel_background_color'];
            $row['textcolor'] = $colors['minimal_fuel_font_color'];
        }

        if ($row['result_online'] <= $critical_fuel) {
            $row['bgcolor']   = $colors['critical_fuel_background_color'];
            $row['textcolor'] = $colors['critical_fuel_text_color'];
        }
		
		$row['uptimecalc'] = $posmgmt->uptimecalc($row['pos_id']);
        $disp_rows[$key]=$row;
    }

	$pager = array('numitems' => $towercount, 'limit' => $args['limit'], 'page' => $args['page']);
	$eveRender->Assign('rows',     $rows);
    $eveRender->Assign('pager',     $pager);
    $eveRender->Assign('sb',     $user_track[1]);
	$eveRender->Assign('st',     $st);
    $eveRender->Assign('arrposize', array(1 => 'Small', 2 => 'Medium', 3 => 'Large'));
    $eveRender->Assign('config',    $config);
    $eveRender->Assign('poses',     $disp_rows);
    $eveRender->Display('track.tpl');

} else {
    $eve->SessionSetVar('errormsg', 'User not logged in or Access Denied - Please login or Contact your Admin!');
    $eve->RedirectUrl('login.php');
}

?>
