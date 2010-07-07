<?php
/**
 * Pos-Tracker2
 *
 * POS-Tracker module loader
 *
 * PHP version 5
 *
 * LICENSE: This file is part of POS-Tracker2.
 * POS-Tracker2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3 of the License.
 *
 * POS-Tracker2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with POS-Tracker2.  If not, see <http://www.gnu.org/licenses/>.
 *

 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @author      Andy Snowden <forumadmin@eve-razor.com>
 * @copyright  2007-2009 (C)  Stephen Gulick, DeTox MinRohim, and Andy Snowden
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @package    POS-Tracker2
 * @version    SVN: $Id: module.php 243 2009-04-26 16:10:33Z stephenmg $
 * @link       https://sourceforge.net/projects/pos-tracker2/
 * @link       http://www.eve-online.com/
 */

include_once 'eveconfig/config.php';
include_once 'includes/dbfunctions.php';

EveDBInit();

include_once 'includes/eveclass.php';
include_once 'includes/eveRender.class.php';

$colors    = $eveRender->themeconfig;

$eve     = New Eve();

$access = $eve->SessionGetVar('access');


$additional_header = array();

// NEEDS SOME CHECKING AROUND HERE, THIS IS ONLY AN EXAMPLE

$op   = $eve->VarCleanFromInput('op');
$mod  = $eve->VarCleanFromInput('name');
$func = $eve->VarCleanFromInput('func');

if (empty($func)) { $func = 'index'; }

$eveRender = New eveRender($config, $mod, false);

if (is_dir('mods/'.$mod.'/plugins')) {
    array_push($eveRender->plugins_dir, 'mods/'.$mod.'/plugins');
}
if (is_dir('mods/'.$mod.'/style') && file_exists('mods/'.$mod.'/style/style.css')) {
    $additional_header[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"mods/".$mod."/style/style.css\" />";
}

$eveRender->Assign('access', $access);
$eveRender->Assign('config', $config);

// Called it index for easy access... would need to be less noobish
include_once 'mods/'.$mod.'/index.php';
//echo $op;exit;
//Execute the function from func
$function = $mod.'_'.$func;
if (function_exists($function)) {

    $template = $function();

    // $template is filled by the $op.php file. Not clean, needs some work
    ModHead();
    $eveRender->Display($template);
    ModFoot();

} else {
    echo 'Error';exit;
    $eve->SessionSetVar('errormsg', 'Error somewhere!');
    $eve->RedirectUrl('index.php');
}


function ModHead()
{

    global $eve, $eveRender, $additional_header;

    if ($eve->SessionGetVar('noheader')) {
        $eve->SessionSetVar('noheader', false);
        return null;
    }
    return $eveRender->display('header.tpl');
}


function ModFoot()
{

    global $eve, $eveRender;

    if ($eve->SessionGetVar('nofooter')) {
        $eve->SessionSetVar('nofooter', false);
        return null;
    }

    return $eveRender->display('footer.tpl');

}


function AjaxOutput($args)
{

    if (!is_array($args)) {
        $data = array('result' => $args);//array('data' => $args);
    } else {
        $data = $args;
    }
    // set locale to en_US to ensure correct decimal delimiters
    if (stristr(getenv('OS'), 'windows')) {
        setlocale(LC_ALL, 'eng');
    } else {
        setlocale(LC_ALL, 'en_US');
    }

    // convert the data to UTF-8 if not already encoded as such
    // Note: this isn't strict test but relying on the site language pack encoding seems to be a good compromise
    if (_CHARSET != 'UTF-8') {
        $data = convertToUTF8($data);
    }
    // check PHP version and use internal json_encode if >=5.2.0
    if(version_compare(phpversion(), '5.2.0', '>=')==1) {
        // >= 5.2.0 - use built-in json encoding
        $output = json_encode($data);
    } else {
        // < 5.2.0 - use external JSON library
        require_once 'includes/JSON/JSON.php';
        $json = new Services_JSON();
        $output = $json->encode($data);
    }

    header('HTTP/1.0 200 OK');
    if ($xjsonheader == true) {
        header('X-JSON:(' . $output . ')');
    }
    echo $output;
    exit;
}

function convertToUTF8($input='')
{
    if (is_array($input)) {
        $return = array();
        foreach($input as $key => $value) {
            $return[$key] = convertToUTF8($value);
        }
        return $return;
    } elseif (is_string($input)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($input, 'UTF-8', _CHARSET);
        } else {
            return utf8_encode($input);
        }
    } else {
        return $input;
    }
}

?>