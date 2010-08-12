<?php

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';



$eveRender = New eveRender($config, '', false);
//$colors    = $eveRender->themeconfig; old.
$eve     = New Eve();
$posmgmt = New POSMGMT();

$userinfo = $posmgmt->GetUserInfo();
$eve->SessionSetVar('userlogged', 1);
$access = $eve->SessionGetVar('access');
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);
$eveRender->Assign('access', $access);

include_once 'themes/posmanager/style/theme'.$theme_id.'.php';

//Begin Tower sorting Code
$sb = $eve->VarCleanFromInput('sb');
if(is_numeric($sb)) {
    $args['scolumn']=$sb;
}
$st = $eve->VarCleanFromInput('st');

//User Display Options
$action = $eve->VarCleanFromInput('action');
switch($action) {
    case 'Sort Towers':
        $sb     = $eve->VarCleanFromInput('sortlist');
        $eve->RedirectUrl('track.php?sb='.$sb);
    break;
    case 'Display':
        $usrlimit     = $eve->VarCleanFromInput('pagernumsel');
        $eve->SessionSetVar('usrlimit', $usrlimit);
	break;
	case 'Show Stront Timers':
        $eve->RedirectUrl('track.php?st='.$st);
	break;
	case 'Hide Stront Timers':
        $eve->RedirectUrl('track.php?st='.$st);
	break;
}



if ($access >= "1") {
    if ($access >= "2") {
        //semi moved out of user login to remove delays, basically it checks the age then complains if the data is old to admin level only accounts, which can then go and update the data via the admin panel..this should never been seen by the cron tab users, unless it fails.
        if ($access >= "4") {
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
            if ($sovtimedifference >= "86400") { //1 day
                $errormsg = '<b>Warning, Your Sovereignty data is out of date.</b>' . $sovtime . '<br />';

            }
            if ($allytimedifference >= "604800") {  #1 week
                $errormsg .= 'Warning, Your Alliance data is out of date.' . $allytime . '<br />';
            }
            if ($errormsg) {
                $eve->SessionSetVar('errormsg', $errormsg);
            }
        }
    }
  $userlimit = $eve->SessionGetVar('usrlimit');
  //Following will be removed after BETA
  if(isset($config['pagelimit'])) {
      $args['limit']    = $config['pagelimit'];
  }
  //Will be removed after BETA! FIX Your config
  else {
      $args['limit']    = 15; // NEED TO GO IN CONFIG!
  }
  if(isset($userlimit) && is_numeric($userlimit)) {
      $args['limit']=$userlimit;
  } else {
    $args['limit']    = $config['pagelimit'];
  }
    $args['page']     = $eve->VarCleanFromInput('page');
    $args['startnum'] = $eve->VarCleanFromInput('startnum');

    $rows       = $posmgmt->GetAllPos2($args);
    $towercount = $posmgmt->GetAllPos2Count();

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
            $row['pos_status_img'] = "online.gif";//echo '<td>&nbsp;</td><td>';
        }

        //$sortAarr[]               = $row['result_online'];

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
    //array_multisort($sortAarr, SORT_ASC, $rows);
  //echo '<pre>';print_r($_SESSION); echo '</pre>';exit;

    $arrporace = array(1  => 'Amarr CT',
                       2  => 'Caldari CT',
                       3  => 'Gallente CT',
                       4  => 'Minmatar CT',
                       5  => 'Angel CT',
                       6  => 'Blood CT',
                       7  => 'Dark Blood CT',
                       8  => 'Domination CT',
                       9  => 'Dread Guristas CT',
                       10 => 'Guristas CT',
                       11 => 'Sansha CT',
                       12 => 'Serpentis CT',
                       13 => 'Shadow CT',
                       14 => 'True Sansha CT');

    $sortlist = array(1  => 'Status',
                       2  => 'Location',
                       3  => 'Region',
                       4  => 'Tower Name',
                       5  => 'Starbase Type',
                       6  => 'Fuel Tech Name',
                       7  => 'Assistant Fuel Tech Name',
                       8  => 'Outpost Name',
                       9  => 'Starbase Size',
                       10 => 'Starbase Race',);
                       
    $pagernumlist=array(10=>'10', 15=>'15', 25=>'25', 30=>'30', 50=>'50', 100=>'100');

    $pager = array('numitems' => $towercount, 'limit' => $args['limit'], 'page' => $args['page']);

    $eveRender->Assign('pager',     $pager);
    $eveRender->Assign('sb',     $sb);
    $eveRender->Assign('sortlist',     $sortlist);
    $eveRender->Assign('pagernumlist',     $pagernumlist);
    $eveRender->Assign('arrposize', array(1 => 'Small', 2 => 'Medium', 3 => 'Large'));
    $eveRender->Assign('arrporace', $arrporace);
    $eveRender->Assign('config',    $config);
    $eveRender->Assign('poses',     $disp_rows);
	$eveRender->Assign('st',     $st);
    $eveRender->Display('track.tpl');

} else {
    $eve->SessionSetVar('errormsg', 'User not logged in or Access Denied - Please login or Contact your Admin!');
    $eve->RedirectUrl('login.php');
}

?>
