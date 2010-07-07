<?php


function smarty_function_getbaseurl($params, &$smarty)
{

    //if (!isset($params['name']) || empty($params['name'])) {
    //    return null;
    //}

    global $eve;
    // Get the last message
    return $eve->GetBaseURL();

}

?>