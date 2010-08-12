<?php
include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';

$eveRender = New eveRender($config, $mod, false);
$colors    = $eveRender->themeconfig;
$eveRender->Assign('config',    $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$step = $eve->VarCleanFromInput('step');

$step = ((empty($step)) ? $step = 1 : $step);

$userinfo = $posmgmt->GetUserInfo();
$eveRender->Assign('userinfo',    $userinfo);
$theme_id = $eve->SessionGetVar('theme_id');
$eveRender->Assign('theme_id', $theme_id);
$access = $eve->SessionGetVar('access');

if ( $access >= 2 ) {
	$eveRender->Assign('access', $access);
} else {
    $eve->SessionSetVar('errormsg', 'Access Denied - Please login!');
    $eve->RedirectUrl('login.php');
}

$eveRender->Assign('step',       $step);

$action = $eve->VarCleanFromInput('action');

if ($step == 2) {
    // Select Constellation
    $regionID = $eve->VarCleanFromInput('regionID');

    if (!$regionID) {
        $eve->SessionSetVar('errormsg', 'No Regions selected!');
        $eve->RedirectUrl('addpos.php');
    }

    $constellations = $posmgmt->GetConstellationInfo($regionID);
    foreach ($constellations as $constellationID => $constellation) {
        $arrconstellation[$constellationID] = $constellation['constellationName'];
    }

    $eveRender->Assign('regionID',         $regionID);
    $eveRender->Assign('arrconstellation', $arrconstellation);
    $eveRender->Display('addpos.tpl');
    exit;
} elseif ($step == 3) {
    $constellationID = $eve->VarCleanFromInput('constellationID');
    if (!$constellationID) {
        $eve->SessionSetVar('errormsg', 'No Constellations selected!');
        $eve->RedirectUrl('addpos.php');
    }
    $regionID = $eve->VarCleanFromInput('regionID');

    $systems = $posmgmt->GetSystemFromConst($constellationID);
    foreach($systems as $solarSystemID => $system) {
        $arrsystems[$solarSystemID] = $system['solarSystemName'];
    }

    $eveRender->Assign('regionID',         $regionID);
    $eveRender->Assign('arrsystems',       $arrsystems);
    $eveRender->Assign('constellationID',  $constellationID);
    $eveRender->Display('addpos.tpl');
    exit;
} elseif ($step == 4) {
    $regionID        = $eve->VarCleanFromInput('regionID');
    $solarSystemID   = $eve->VarCleanFromInput('solarSystemID');
    $constellationID = $eve->VarCleanFromInput('constellationID');
    if (!$solarSystemID) {
        $eve->SessionSetVar('errormsg', 'No Systems selected!');
        $eve->RedirectUrl('addpos.php');
    }

    $moons = $posmgmt->GetMoonsFromSystem($solarSystemID);
    foreach($moons as $moonID => $moon) {
        $arrmoons[$moonID] = $moon['moonName'];
    }

    $eveRender->Assign('arrmoons',         $arrmoons);
    $eveRender->Assign('regionID',         $regionID);
    $eveRender->Assign('constellationID',  $constellationID);
    $eveRender->Assign('solarSystemID',    $solarSystemID);
    $eveRender->Display('addpos.tpl');
    exit;
} elseif ($step == 5) {
    $moonID          = $eve->VarCleanFromInput('moonID');
    $regionID        = $eve->VarCleanFromInput('regionID');
    $solarSystemID   = $eve->VarCleanFromInput('solarSystemID');
    $constellationID = $eve->VarCleanFromInput('constellationID');
    if (!$moonID) {
        $eve->SessionSetVar('errormsg', 'No Moons selected!');
        $eve->RedirectUrl('addpos.php');
    }

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

    $eveRender->Assign('arrposize',        array(1 => 'Small', 2 => 'Medium', 3 => 'Large'));
    $eveRender->Assign('arrporace',        $arrporace);
    $eveRender->Assign('moonID',           $moonID);
    $eveRender->Assign('regionID',         $regionID);
    $eveRender->Assign('constellationID',  $constellationID);
    $eveRender->Assign('solarSystemID',    $solarSystemID);
    $eveRender->Display('addpos.tpl');
    exit;

} elseif ($step == 6) {

    $regionID        = $eve->VarCleanFromInput('regionID');
    $solarSystemID   = $eve->VarCleanFromInput('solarSystemID');
    $constellationID = $eve->VarCleanFromInput('constellationID');

    $pos_size         = $eve->VarCleanFromInput('pos_size');
    $pos_race         = $eve->VarCleanFromInput('pos_race');
    //$system           = $eve->VarCleanFromInput('solarSystemID');
    $sovereignity     = $eve->VarCleanFromInput('sovereignity');
    $uranium          = $eve->VarCleanFromInput('uranium');
    $oxygen           = $eve->VarCleanFromInput('oxygen');
    $mechanical_parts = $eve->VarCleanFromInput('mechanical_parts');
    $coolant          = $eve->VarCleanFromInput('coolant');
    $robotics         = $eve->VarCleanFromInput('robotics');
    $isotope          = $eve->VarCleanFromInput('isotope');
    $ozone            = $eve->VarCleanFromInput('ozone');
    $heavy_water      = $eve->VarCleanFromInput('heavy_water');
    $strontium        = $eve->VarCleanFromInput('strontium');
    $struct_amount    = $eve->VarCleanFromInput('struct_amount');
    $status           = $eve->VarCleanFromInput('status');
    $towerName        = $eve->VarCleanFromInput('towerName');
    $moonID           = $eve->VarCleanFromInput('moonID');

    $statictower = $posmgmt->GetTowerTypeID(array('pos_size' => $pos_size, 'pos_race' => $pos_race));
//echo '<pre>';print_r($statictower);echo '</pre>';exit;
    $typeID          = $statictower['typeID'];
    $evetowerID      = null;
    $corp            = $userinfo['corp'];
    $allianceid      = $userinfo['allianceID'];
    $systemID        = $solarSystemID;
    $charters_needed = 0;
    $pos_status      = $status;

//echo $status;exit;
    $args = array('pos_size'         => $pos_size,
                  'typeID'           => $typeID,
                  'corp'             => $userinfo['corp'],
                  'allianceid'       => $allianceid,
                  'pos_race'         => $pos_race,
                  'system'           => $system,
                  'sovereignity'     => ((!$sovereignity) ? 0 : 1),
                  'uranium'          => $uranium,
                  'oxygen'           => $oxygen,
                  'mechanical_parts' => $mechanical_parts,
                  'coolant'          => $coolant,
                  'robotics'         => $robotics,
                  'isotope'          => $isotope,
                  'ozone'            => $ozone,
                  'heavy_water'      => $heavy_water,
                  'strontium'        => $strontium,
                  'owner_id'         => $userinfo['id'],
                  'status'           => $status,
                  'towerName'        => $towerName,
                  'systemID'         => $systemID,
                  'moonID'           => $moonID,
                  'pos_status'       => $pos_status,
                  'systemID'         => $solarSystemID);
//echo '<pre>';print_r($args);echo '</pre>';exit;
    if (!$pos_id = $posmgmt->AddNewPOS($args)) {
        $eve->RedirectUrl('addpos.php');
    }

    $eve->SessionSetVar('statusmsg', 'POS Added!');
    $eve->RedirectUrl('addstructure.php?i='.$pos_id);
}

$regions = $posmgmt->GetInstalledRegions();
foreach($regions as $regionID => $region) {
    $arrregions[$regionID] = $region['regionName'];
}

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

$eveRender->Assign('arrregions', $arrregions);

$eveRender->Display('addpos.tpl');

?>
