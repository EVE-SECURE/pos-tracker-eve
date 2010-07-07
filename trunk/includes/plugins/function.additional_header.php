<?php
/*
 * @author   Jörg Napp - PostNuke Dev-Team
 * @since    03. Feb. 04
 * @param    array    $params     All attributes passed to this function from the template
 * @param    object   $smarty     Reference to the Smarty object
 * @return   string   the charset
 */
function smarty_function_additional_header($params, &$smarty)
{

    global $additional_header;

    if(isset($additional_header)) {
        $return = @implode("\n", $additional_header);
    } else {
        $return = '';
    }

    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $return);
    } else {
        return $return;
    }

}

?>