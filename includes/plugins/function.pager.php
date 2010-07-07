<?php

function smarty_function_pager($params, &$smarty)
{

    $startnum = $params['startnum'];
    $numitems = $params['numitems'];

    // Going to be common so let's use it
    $searchphrase = $params['searchphrase'];

    if (!$numitems) {
        return null;
    }

    $max   = $params['numitems'];
    $split = $params['limit'];

    $html = "<br /><p><strong>[</strong> ";

    $endpage = ceil($max / $split);

    $page = Eve::VarCleanFromInput('page');

    $qstring = Eve::ServerGetVar('QUERY_STRING');

    $script = Eve::ServerGetVar('SCRIPT_NAME');
    //$script = substr($script, -1, strlen($script));

    if ($page) {
        $url = preg_replace("/&page=([0-9]?[0-9]?[0-9])/", "", $qstring);//return $url;
        if ($url == $qstring) { $url = preg_replace("/page=([0-9]?[0-9]?[0-9])/", "", $qstring); }
    } else {
        $url = $qstring;//urlencode($qstring);
        $page = 1;
    }
    //if (eregi('.html', $url)) {
        //$url = 'a='.Eve::SessionGetVar('kburl');
    //}
    // Fixing damn &amp; for validation
    $url = preg_replace("/&/", "&amp;", $url);
    for ($i = 1; $i <= $endpage; $i++) {
        if ($i != $page) {
            if ($i == 1 || $i == $endpage || (($i >= $page - 1 && $i <= $page + 1))) {
                if ($i != 1) {
                    $html .= "<a href=\"".$script."?".$url.((empty($url)) ? "" : "&amp;")."page=".$i.((!empty($searchphrase)) ? "&amp;searchphrase=".urlencode($searchphrase) : "")."\" title=\"Page ".$i."\">".$i."</a>&nbsp;";
                } else {
                    $html .= "<a href=\"".$script."?".$url."\" title=\"Page ".$i."\">".$i."</a>&nbsp;";
                }
            } elseif ($i < $page && !$dotted) {
                $dotted = true;
                $html .= "<strong>..&nbsp;</strong>";
            } elseif ($i > $page && !$ldotted) {
                $ldotted = true;
                $html .= "<strong>..&nbsp;</strong>";
            }
        } else {
            $html .= "<strong>".$i."</strong>&nbsp;";
        }
    }
    $html .= "<strong>]</strong></p>";
    return $html;

}

?>