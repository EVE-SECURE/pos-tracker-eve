// $Id: install.js 153 2008-09-05 09:35:11Z eveoneway $
function ajax_CheckDB()
{
    document.getElementById('loader').style.display = '';
    document.getElementById('loaderblank').style.display = 'none';
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    check_dbhost    = document.getElementById('dbhost');
    check_dbuname   = document.getElementById('dbuname');
    check_dbname    = document.getElementById('dbname');
    check_dbpass    = document.getElementById('dbpass');
    check_dbprefix  = document.getElementById('dbprefix');
    check_dbupgrade = document.getElementById('dbupgrade');

    var url     = 'install.php?step=1';
    var fullurl = url + '&do=Ajax_CheckDB'
                      + '&dbuname='  + encodeURIComponent(check_dbuname.value)  + ''
                      + '&dbhost='   + encodeURIComponent(check_dbhost.value)   + ''
                      + '&dbname='   + encodeURIComponent(check_dbname.value)   + ''
                      + '&dbpass='   + encodeURIComponent(check_dbpass.value)   + ''
                      + '&dbprefix=' + encodeURIComponent(check_dbprefix.value) + ''
                      + '&dbupgrade=';

    if (check_dbupgrade.checked) {
        fullurl = fullurl + '1';
        document.getElementById('btnNext').innerHTML  = 'Upgrade tables';
    } else {
        fullurl = fullurl + '0';
    }

    http.open("POST", fullurl, true);
    http.send(null);
    http.onreadystatechange = statechange_dbinfo;
}

function ajax_WriteConfig()
{
    document.getElementById('loader2').style.display = '';
    document.getElementById('loaderblank2').style.display = 'none';
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    check_dbhost   = document.getElementById('dbhost');
    check_dbuname  = document.getElementById('dbuname');
    check_dbname   = document.getElementById('dbname');
    check_dbpass   = document.getElementById('dbpass');
    check_dbprefix = document.getElementById('dbprefix');

    var url     = 'install.php?step=1';
    var fullurl = url + '&do=Ajax_WriteConfig'
                      + '&dbuname='  + encodeURIComponent(check_dbuname.value)  + ''
                      + '&dbhost='   + encodeURIComponent(check_dbhost.value)   + ''
                      + '&dbname='   + encodeURIComponent(check_dbname.value)   + ''
                      + '&dbpass='   + encodeURIComponent(check_dbpass.value)   + ''
                      + '&dbprefix=' + encodeURIComponent(check_dbprefix.value) + '';
    http.open("POST", fullurl, true);
    http.send(null);
    http.onreadystatechange = statechange_dbwrite;
}

function statechange_dbinfo()
{
    if (http.readyState == 4) {
        var html = http.responseText;
        document.getElementById('dbinfo').innerHTML = html;
        document.getElementById('loader').style.display = 'none';
        document.getElementById('loaderblank').style.display = '';

        if (html.substr(0, 11) == 'DATABASE OK') {
            document.getElementById('btnWrite').disabled  = false;
            document.getElementById('dbhost').disabled    = true;
            document.getElementById('dbuname').disabled   = true;
            document.getElementById('dbname').disabled    = true;
            document.getElementById('dbpass').disabled    = true;
            document.getElementById('dbprefix').disabled  = true;
        }
    }
}

function statechange_dbwrite()
{
    if (http.readyState == 4) {
        var html = http.responseText;
        document.getElementById('dbinfo').innerHTML = html;
        document.getElementById('loader2').style.display = 'none';
        document.getElementById('loaderblank2').style.display = '';
        document.getElementById('btnTest').disabled  = true;
        document.getElementById('btnWrite').disabled = true;
        document.getElementById('btnNext').disabled = false;
    }
}

function ajax_InstallTables()
{
    document.getElementById('loader2').style.display = '';
    document.getElementById('loaderblank2').style.display = 'none';
    document.getElementById('dbinfo').innerHTML = 'Creating/Updating tables';
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    check_dbupgrade = document.getElementById('dbupgrade');

    if (check_dbupgrade.checked) {
        var url = 'install.php?step=2&do=Ajax_UpgradeTables';
    } else {
        var url = 'install.php?step=2&do=Ajax_WriteTables';
    }

    http.open("GET", url, true);
    http.send(null);
    http.onreadystatechange = statechange_tablewrite;
}

function statechange_tablewrite()
{
    if (http.readyState == 4) {
        var html = http.responseText;

        check_dbupgrade = document.getElementById('dbupgrade');

        if (html.substr(0, 4) == 'done') {
            if (check_dbupgrade.checked) {
                location.href = 'install.php?step=2&upgrade=1';
            } else {
                location.href = 'install.php?step=2';
            }
        }
    }
}

function ajax_InstallRegion(regionID)
{
    document.getElementById('loader_'+regionID).style.display = '';
    document.getElementById('loaderblank_'+regionID).style.display = 'none';
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    tdregion = document.getElementById('row_'+regionID).innerHTML

    var url     = 'admin.php?action=moons';
    var fullurl = url + '&do=Ajax_InstallRegion'
                      + '&regionID=' + encodeURIComponent(regionID) + '';
    http.open("POST", fullurl, true);
    http.send(null);
    http.onreadystatechange = statechange_regionwrite;
}

function statechange_regionwrite()
{
    if (http.readyState == 4) {
        var html = http.responseText;

        var regionID = html;
        document.getElementById('loader_'+regionID).style.display = 'none';
        document.getElementById('loaderblank_'+regionID).style.display = '';

        tdregion = document.getElementById('row_'+regionID).innerHTML
        btn = document.getElementById('region_'+regionID).innerHTML

        if (tdregion == 'Yes') {
            tdregion = 'No';
        } else {
            tdregion = 'Yes';
        }

        if (btn == 'Install') {
            btn = 'Uninstall';
        } else {
            btn = 'Install';
        }
        document.getElementById('row_'   + regionID).innerHTML = tdregion;
        document.getElementById('region_'+ regionID).innerHTML = btn;

    }
}
