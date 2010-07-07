<?php
// $Id: class.minmatar.php 165 2008-09-19 17:11:44Z eveoneway $

class Minmatar
{

    function GetMinmatarTowers()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."tower_info
                WHERE  pos_race = '4'";

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

}

?>