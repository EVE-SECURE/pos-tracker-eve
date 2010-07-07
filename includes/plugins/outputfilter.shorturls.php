<?php
// $Id: outputfilter.shorturls.php 51 2008-06-30 14:31:03Z eveoneway $
// ----------------------------------------------------------------------
// PostNuke Content Management System
// Copyright (C) 2002 by the PostNuke Development Team.
// http://www.postnuke.com/
// ----------------------------------------------------------------------
// Based on:
// PHP-NUKE Web Portal System - http://phpnuke.org/
// Thatware - http://thatware.org/
// ----------------------------------------------------------------------
// LICENSE
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

function smarty_outputfilter_shorturls($source, &$smarty)
{
//echo 'a'.$source;exit;
    global $eve;

    $base_url = $eve->GetBaseUrl();
    $prefix = '|"(?:'.$base_url.')?';

  $in = array(
    $prefix . 'index.php"|',
    $prefix . 'index.php\?a=home"|',
    $prefix . 'index.php\?a=portrait_grab"|',
    $prefix . 'index.php\?a=kill_detail&(?:amp;)?kll_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=pilot_detail&(?:amp;)?plt_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=corp_detail&(?:amp;)?crp_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=alliance_detail&(?:amp;)?all_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=system_detail&(?:amp;)?sys_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=related&(?:amp;)?kll_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=campaigns&(?:amp;)?view=details&(?:amp;)?ctr_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=news&(?:amp;)?sid=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=skillsheet&(?:amp;)?plt_id=([\w\d\.\:\_\/]+)"|',
    $prefix . 'index.php\?a=([\w\d\.\:\_\/]+)"|'
  );/*
  $in = array(
    'index.php"|',
    'index.php\?a=home"|',
    'index.php\?a=([\w\d\.\:\_\/]+)"|'
  );*/
/*
  $out = array(
    '"index.html"',
    '"home.html"',
    '"$1.html"'
  );*/
  //$base_url = '';

  $out = array(
    '"'.$base_url.'index.html"',
    '"'.$base_url.'home.html"',
    '"'.$base_url.'portrait.html"',
    '"'.$base_url.'kill-$1.html"',
    '"'.$base_url.'pilot-$1.html"',
    '"'.$base_url.'corp-$1.html"',
    '"'.$base_url.'alliance-$1.html"',
    '"'.$base_url.'system-$1.html"',
    '"'.$base_url.'related-$1.html"',
    '"'.$base_url.'campaign-$1.html"',
    '"'.$base_url.'article-$1.html"',
    '"'.$base_url.'skillsheet-$1.html"',
    '"'.$base_url.'$1.html"'
  );

  $source = preg_replace($in, $out, $source);

  return $source;

}

?>