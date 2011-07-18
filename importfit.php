<?php

/* $Id$ */

include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include 'includes/class.pos.php';
include_once 'includes/eveRender.class.php';
include_once 'eveconfig/config.php';
$eveRender = New eveRender($config, $mod, false);
$eveRender->Assign('config', $config);

$eve     = New Eve();
$posmgmt = New POSMGMT();

$access = $eve->SessionGetVar('access');
$access = explode('.',$access);
$eveRender->Assign('access', $access);

if (!in_array('1', $access) && !in_array('5', $access) && !in_array('6', $access)) {
    $eve->RedirectUrl('track.php');
}

if (empty($pos_id)) {
    $pos_id = $eve->VarCleanFromInput('pos_id');
}
if (empty($pos_id)) {
    $eve->SessionSetVar('errormsg', 'No POS ID!');
    $eve->RedirectUrl('track.php');
}
$tower['pos_id']=$pos_id;
$action = $eve->VarCleanFromInput('action');

switch($action) {
    case 'Import Structures':
		$eveRender->Assign('tower',         $tower);
		$eveRender->Display('importfit.tpl');
	break;
	case 'Send File':
	$tmp_name=$_FILES["fitimport"]["tmp_name"];
		if (file_exists($tmp_name)) {
			try {
				$xml = simplexml_load_file($tmp_name);
			} catch (Exception $e) {
				$eve->SessionSetVar('errormsg', 'File Not Valid!');
			}
			$structures=array();
				if($_POST['xmlstyle']=='mypos')
				{
					foreach ($xml->xpath('//ItemID') as $key => $structure) {
						$posmgmt->addstructure($structure, $pos_id, 1);
                        $typeID=intval($structure);
						$typeName=$posmgmt->getStructureName($typeID);
						$structures[$key]=array('typeID'=>(int)$structure[0], 'typeName'=>$typeName);
					}
				}
				if($_POST['xmlstyle']=='tracker')
				{
					foreach ($xml->xpath('//structure') as $key =>$structure) {
						$posmgmt->addstructure($structure['typeID'], $pos_id, $structure['online']);
						$structures[$key]=array('typeID'=>$structure['typeID'], 'typeName'=>$structure['typeName']);
					}
				}
			//echo"<pre>";print_r($structures);echo"</pre>";
			$eveRender->Assign('structures',     $structures);
			$eveRender->Assign('pos_id', $pos_id);
			$eveRender->Display('importfit_add.tpl');
			} else {
		      $eve->SessionSetVar('errormsg', 'Failed to Open File!');
			}
	break;
}

?>