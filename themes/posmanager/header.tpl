<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en">
<head>
  <title>POS-Tracker FGV</title>
  <!--[if $theme_id >= 1]-->
  <link href="themes/<!--[$config.theme]-->/style/theme<!--[$theme_id]-->.css" rel="stylesheet" type="text/css" />
  <!--[else]-->
  <link href="themes/<!--[$config.theme]-->/style/theme1.css" rel="stylesheet" type="text/css" />
  <!--[/if]-->
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <!--[additional_header]-->
  <script language="JavaScript" type="text/javascript">
	var Lst;
	function CngCls(obj){
	 if (typeof(obj)=='string') obj=document.getElementById(obj);
	 if (Lst) Lst.className='';
	 obj.className='current';
	 Lst=obj;
	}
</script>
</head>
<body id='header' onload="CngCls('<!--[$pID]-->')">
  <div id='navi'>
    <!--[if (in_array('1', $access) || in_array('5', $access) || in_array('6', $access))]-->
      <div class="navib"><a href="track.php" title="POS Tracking" id="track" onclick="CngCls();">POS Track</a></div>
      <div class="navib"><a href="fuel_calculator.php" title="Fuel Calculator" id="fuelcalc" onclick="CngCls();">Fuel Calculator</a></div>
      <div class="navib"><a href="fuelbill.php" title="Fuel Bill"  id="fuelbill" onclick="CngCls();">Fuel Bill</a></div>
	<!--[if (in_array('60', $access) || in_array('61', $access) || in_array('5', $access) || in_array('6', $access))]-->
	  <div class="navib"><a href="outpost.php" title="Outpost" id="outpost" onclick="CngCls();">Outposts</a></div>
	<!--[/if]-->
	<!--[if (in_array('42', $access) || in_array('43', $access) || in_array('44', $access) || in_array('5', $access) || in_array('6', $access))]-->
      <div class="navib"><a href="production.php" title="Production" id="production" onclick="CngCls();">Production</a></div>
    <!--[/if]-->  
    <!--[if (in_array('40', $access) || in_array('5', $access) || in_array('6', $access))]-->
	  <div class="navib"><a href="jobs.php" title="Jobs" id="jobs" onclick="CngCls();">Jobs</a></div>
    <!--[/if]-->
	<!--[if (in_array('5', $access) || in_array('6', $access))]-->
	<div class="navib"><a href="admin.php" title="Admin Panel" id="admin" onclick="CngCls();">Admin Panel</a></div>
	<!--[/if]-->
	  <div class="navib"><a href="user.php" title="User Panel" id="user" onclick="CngCls();">User Panel</a></div>
      <div class="navib"><a href="logout.php" title="Logout">Logout</a></div>
      <div class="navib"><a href="about.php" title="About" id="about" onclick="CngCls();">About</a></div>
    <!--[else]-->
      <div class="navib"><a href="login.php" title="Login" id="login">Login</a></div>
      <div class="navib"><a href="register.php" title="Register" id="register">Register</a></div>
      <div class="navib"><a href="about.php" title="About" id="about" onclick="CngCls();">About</a></div>
    <!--[/if]-->
</div>
  <!--[getstatusmsg]-->
<br>