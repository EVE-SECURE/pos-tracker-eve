<?php


function smarty_function_getstatusmsg()
{
    global $eve;
    // Get the last message
    $statusmsg = $eve->GetStatusMsg();

    return ((empty($statusmsg)) ? '' : '<div class="statusmsg">'.$statusmsg.'</div>');

}

?>