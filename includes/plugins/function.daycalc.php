<?php


function smarty_function_daycalc($params, &$smarty)
{

    if (!isset($params['hours']) || empty($params['hours'])) {
        return 0;
    }

    $hours = $params['hours'];

    if ($hours >= "24") {
        $d = floor($hours / 24);
        $h = ($hours - ($d * 24));
        $daycalc = $d . "d " . $h . "h";
    } else {
        $h = $hours;
        $daycalc = $h . "h";
    }

    if (isset($params['assign']) && !empty($params['assign'])) {
        $smarty->Assign($params['assign'], $daycalc);
    } else {
        return $daycalc;
    }

}

?>