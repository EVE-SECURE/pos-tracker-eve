<?php
// $Id: install.php 209 2008-10-29 10:41:26Z eveoneway $

function MoonDB_install()
{

    global $posmgmt;

    $dbconn =& DBGetConn(true);

    $sql = file_get_contents('mods/MoonDB/sql/moondb.sql');
    $sql = preg_replace('/%prefix%/', TBL_PREFIX, $sql);

    $queries = explode(";", $sql);

    $dbconn->Execute(trim($queries[0]));

    $dbconn->Execute(trim($queries[1]));

    if ($dbconn->ErrorNo() != 0) {
        Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
        return false;
    }

    $vars = array('test' => 1, 'test2' => 2);

    foreach ($vars as $name => $var) {
        $posmgmt->ModuleSetVar('MoonDB', $name, $var);
    }

    Eve::SessionSetVar('statusmsg', 'Module MoonDB Installed');
    return 1;

}


function MoonDB_uninstall()
{

    global $posmgmt;

    $tables = array(TBL_PREFIX.'moonmaterials');
    $values = array('test', 'test1', 'test2');

    $dbconn =& DBGetConn(true);

    foreach ($tables as $table) {
        $dbconn->Execute("DROP TABLE IF EXISTS ".$table);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', "Problem with table: ".$table);
            return false;
        }
    }

    foreach ($values as $value) {
        $posmgmt->ModuleDelVar('MoonDB', $value);
    }

    return 0;
}

?>