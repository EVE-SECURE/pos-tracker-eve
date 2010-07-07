<?php


function smarty_function_formatnumber($params, &$smarty)
{

    if (!isset($params['value']) || empty($params['value'])) {
        return 0;
    }
    $value   = number_format($params['value'], 0, '.', ',');
    $label   = ((isset($params['label'])   && !empty($params['label']))   ? $params['label']   : true);
    $highest = ((isset($params['highest']) && !empty($params['highest'])) ? $params['highest'] : false);




    /*
    if ($value != 0) {
        //$test = $value - intval($value);echo $test;
        if ($highest) {
            switch($highest) {
                case 'B':
                    $test = ($value / 1000000000) - intval(($value / 1000000000));
                    if ($test > 0) {
                        //$value = number_format($value, 2, '.', ' ');
                        $value = $test;
                    } else {
                        $value = number_format($value);
                    }
                    break;
                case 'M':
                    $test = ($value / 1000000) - intval(($value / 1000000));
                    if ($test > 0) {
                        //$value = number_format($value, 2, '.', ' ');
                        $value = $test;
                    } else {
                        $value = number_format(($value / 1000000));
                    }
                    break;
                case 'K':
                    //$value = $value / 1000;
                    $test = ($value / 1000) - intval(($value / 1000));
                    if ($test > 0) {
                        //$value = number_format($value, 2, '.', ' ');
                        $value = $test;
                    } else {
                        $value = number_format(($value / 1000));
                    }
                    break;
                default: // 'M'
                    $test = ($value / 1000000) - intval(($value / 1000000));
                    if ($test > 0) {
                        //$value = number_format($value, 2, '.', ' ');
                        $value = $test;
                    } else {
                        $value = number_format(($value / 1000000));
                    }
                    break;
            }
        } else {

            if ($value > 1000000000) { //1.250
                $value = number_format(($value / 1000000000), 2, '.', ' ');
                $value = $value . (($label) ? " B" : "");
            } elseif ($value > 1000000) { //1.250
                $value = number_format(($value / 1000000), 2, '.', ' ');
                $value = $value . (($label) ? " M" : "");
            } elseif ($value > 1000) { //1.250
                $value = number_format(($value / 1000), 2, '.', ' ');
                $value = $value . (($label) ? " K" : "");
            } else {
                $value = $value . (($label) ? " Isks" : "");
            }

        }
    }
*/

    if (isset($params['assign']) && !empty($params['assign'])) {
        $smarty->Assign($params['assign'], $value);
    } else {
        return $value;
    }

}

?>