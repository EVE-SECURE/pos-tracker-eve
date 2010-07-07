<?php
// $Id: index.php 165 2008-09-19 17:11:44Z eveoneway $
include_once 'mods/Minmatar/includes/class.minmatar.php';

$minni = New Minmatar();

function Minmatar_index()
{

    global $minni, $eveRender;

    $mintowers = $minni->GetMinmatarTowers();

    $eveRender->Assign('mintowers', $mintowers);

    return 'minmatar.tpl';

}

?>