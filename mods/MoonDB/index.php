<?php
// Moon Database Module
// $Id: index.php 181 2008-09-30 15:48:56Z stephenmg $

include_once 'includes/eveclass.php';
include_once 'includes/class.pos.php';
include_once 'mods/MoonDB/includes/class.moondb.php';

$additional_header[] = '<script type="text/javascript" src="mods/MoonDB/javascript/moondb.js"></script>';

//$moondb = New MoonDB();

function MoonDB_index()
{

    //global $posmgmt, $eveRender;
    global $eveRender, $eve;

    $access = $eve->SessionGetVar('access');

    if ($access >= "1") {;

        $regions   = POSMGMT::GetInstalledRegions();
        $systems   = POSMGMT::GetSystemsWithPos();
        $materials = POSMGMT::GetStaticMaterials();

        $optregions[] = 'All Regions';
        foreach ($regions as $regID => $region) {
            $optregions[$regID] = $region['regionName'];
        }
        $optsystems[] = 'All Systems';
        foreach ($systems as $sysID => $system) {
            $optsystems[$system['solarSystemID']] = $system['solarSystemName'];
        }
        $optmaterials[] = 'All Materials';
        foreach ($materials as $material_id => $material) {
            $optmaterials[$material['material_id']] = $material['material_name'];
        }
        $optmoons[] = 'All Moons';

        $rows = MoonDB::GetMoons();

        $eveRender->Assign('rows',          $rows);
        $eveRender->Assign('regions',       $regions);
        $eveRender->Assign('optregions',    $optregions);
        $eveRender->Assign('systems',       $systems);
        $eveRender->Assign('optmoons',      $optmoons);
        $eveRender->Assign('optmaterials',  $optmaterials);
        $eveRender->Assign('optsystems',    $optsystems);

        return 'index.tpl';
    } else {
        $eve->SessionSetVar('errormsg', 'User not logged in or Access Denied - Please login or Contact your Admin!');
        $eve->RedirectUrl('login.php');
    }
}

function MoonDB_AddNew()
{
    //global $posmgmt, $eveRender;
    global $eveRender, $eve;

    $access = $eve->SessionGetVar('access');

    if ($access >= "1") {;

        $regions   = POSMGMT::GetInstalledRegions();
        $systems   = POSMGMT::GetSystemsWithPos();
        $materials = POSMGMT::GetStaticMaterials();

        $optregions[] = 'All Regions';
        foreach ($regions as $regID => $region) {
            $optregions[$regID] = $region['regionName'];
        }
        $optsystems[] = 'All Systems';
        foreach ($systems as $sysID => $system) {
            $optsystems[$system['solarSystemID']] = $system['solarSystemName'];
        }
        $optmaterials[] = 'All Materials';
        foreach ($materials as $material_id => $material) {
            $optmaterials[$material['material_id']] = $material['material_name'];
        }
        $optmoons[] = 'All Moons';

        $rows = MoonDB::GetMoons();

        $eveRender->Assign('rows',          $rows);
        $eveRender->Assign('regions',       $regions);
        $eveRender->Assign('optregions',    $optregions);
        $eveRender->Assign('systems',       $systems);
        $eveRender->Assign('optmoons',      $optmoons);
        $eveRender->Assign('optmaterials',  $optmaterials);
        $eveRender->Assign('optsystems',    $optsystems);

        return 'add_moon.tpl';
    } else {
        $eve->SessionSetVar('errormsg', 'User not logged in or Access Denied - Please login or Contact your Admin!');
        $eve->RedirectUrl('login.php');
    }
}

function MoonDB_AddNewMaterial()
{
    global $moondb, $eve;

    $access = $eve->SessionGetVar('access');

    if ($access >= "1") {;

        $args = array();

        $args['taken']       = $eve->VarCleanFromInput('taken');
        $args['moonID']      = $eve->VarCleanFromInput('moonID');
        $args['abundance']   = $eve->VarCleanFromInput('abundance');
        $args['notes']       = $eve->VarCleanFromInput('notes');
        $args['material_id'] = $eve->VarCleanFromInput('material_id');

        foreach ($args as $key => $arg) {
            if ($key != 'taken' && empty($arg)) {
                $eve->SessionSetVar('errormsg', 'Argument Missing');
                $eve->RedirectUrl('module.php?name=MoonDB&func=AddNew');
            }
            if ($key == 'taken') {
                $args[$key] = ((!empty($arg)) ? 1 : 0);
            }
        }

        MoonDB::AddNewMoonMaterial($args);

        $eve->SessionSetVar('statusmsg', 'Material Added!');
        $eve->RedirectUrl('module.php?name=MoonDB');

        return true;
    } else {
        $eve->SessionSetVar('errormsg', 'User not logged in or Access Denied - Please login or Contact your Admin!');
        $eve->RedirectUrl('login.php');
    }
}

function MoonDB_GetSystemList()
{

    global $moondb, $eve;

    //$eve->SessionSetVar('noheader', true);
    //$eve->SessionSetVar('nofooter', true);

    $regionID = $eve->VarCleanFromInput('regionID');

    $systems = MoonDB::GetSystemList($regionID);

    $output = "All Systems|";

    foreach ($systems as $system) {
        $output .= "\n".$system['solarSystemName']."|".$system['solarSystemID'];
    }
    //TEST1|TEST2\nTEST3|TEST4";
    //AjaxOutput($output);
    echo $output;
    exit;

}

function MoonDB_GetMoonList()
{

    global $moondb, $eve;

    $systemID = $eve->VarCleanFromInput('systemID');

    $systems = MoonDB::GetMoonList($systemID);

    $output = "All Moons|";

    foreach ($systems as $system) {
        $output .= "\n".$system['moonName']."|".$system['moonID'];
    }

    echo $output;
    exit;

}

?>