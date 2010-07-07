<?php
// $Id: class.moondb.php 181 2008-09-30 15:48:56Z stephenmg $

class MoonDB
{

    function GetMoons()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   ".TBL_PREFIX."moonmaterials.*,
                         ".TBL_PREFIX."evemoons.*,
                         ".TBL_PREFIX."material_static.*
                FROM     ".TBL_PREFIX."moonmaterials,
                         ".TBL_PREFIX."evemoons,
                         ".TBL_PREFIX."material_static
                WHERE    ".TBL_PREFIX."moonmaterials.moonID      = ".TBL_PREFIX."evemoons.moonID
                AND      ".TBL_PREFIX."moonmaterials.material_id = ".TBL_PREFIX."material_static.material_id
                ORDER BY ".TBL_PREFIX."evemoons.moonName ASC";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $row = $result->GetRowAssoc(2);



            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;

    }

    function GetSystemList($regionID = 0)
    {

        if (!$regionID) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."mapsolarsystems
                WHERE    regionID = '".Eve::VarPrepForStore($regionID)."'
                ORDER BY solarSystemName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;

    }

    function GetMoonList($systemID = 0)
    {

        if (!$systemID) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."evemoons
                WHERE    systemID = '".Eve::VarPrepForStore($systemID)."'
                ORDER BY moonName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;

    }

    function AddNewMoonMaterial($args)
    {

        if (!$args) {
            Eve::SessionSetVar('errormsg', 'No Arguments!');
            return false;
        }
		$userinfo = POSMGMT::GetUserInfo();
		$characterID=$userinfo['eve_id'];
        $dbconn =& DBGetConn(true);

        $sql = "INSERT INTO ".TBL_PREFIX."moonmaterials (moonID,
                                                         material_id,
                                                         abundance,
														 notes,
                                                         taken,
														 characterID,
														 datetime)
                                                 VALUES ('".Eve::VarPrepForStore($args['moonID'])      ."',
                                                         '".Eve::VarPrepForStore($args['material_id']) ."',
                                                         '".Eve::VarPrepForStore($args['abundance'])   ."',
                                                         '".Eve::VarPrepForStore($args['notes'])       ."',
														 '".Eve::VarPrepForStore($args['taken'])       ."',
														 '".Eve::VarPrepForStore($characterID)       ."',
														 '".Eve::VarPrepForStore(time())       ."')";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }

}

?>