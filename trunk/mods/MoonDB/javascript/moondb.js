// $Id: moondb.js 166 2008-09-19 17:12:58Z eveoneway $

function ajax_GetSystemList()
{

    var url = 'module.php?name=MoonDB&func=GetSystemList';

    //document.getElementById('loader').style.display = '';
    //document.getElementById('loaderblank').style.display = 'none';
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    regionID = document.getElementById('regionID');

    url = url + '&regionID=' + encodeURIComponent(regionID.options[regionID.selectedIndex].value);

    http.open("POST", url, true);
    http.send(null);
    http.onreadystatechange = statechange_getsystems;
}

function statechange_getsystems()
{
    if (http.readyState == 4) {
        var ajaxStr = http.responseText;

        var html = "";

        arrSys = ajaxStr.split("\n");

        for (var i=0; i<arrSys.length; i++) {
            arrSysInfo = arrSys[i].split("|");
            html = html + "<option value=\"" + arrSysInfo[1] + "\">" + arrSysInfo[0] + "</option>\n";
        }

        document.getElementById('systemID').innerHTML = html;

    }
}

function ajax_GetMoonList()
{

    var url = 'module.php?name=MoonDB&func=GetMoonList';

    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    systemID = document.getElementById('systemID');

    url = url + '&systemID=' + encodeURIComponent(systemID.options[systemID.selectedIndex].value);

    http.open("POST", url, true);
    http.send(null);
    http.onreadystatechange = statechange_getmoons;
}

function statechange_getmoons()
{
    if (http.readyState == 4) {
        var ajaxStr = http.responseText;

        var html = "";

        arrSys = ajaxStr.split("\n");

        for (var i=0; i<arrSys.length; i++) {
            arrSysInfo = arrSys[i].split("|");
            html = html + "<option value=\"" + arrSysInfo[1] + "\">" + arrSysInfo[0] + "</option>\n";
        }
        document.getElementById('moonID').innerHTML = html;
    }
}

function clearText(thefield)
{
    if (thefield.defaultValue==thefield.value) { thefield.value = ""; }
}