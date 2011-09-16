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
</head>
<body>
  <h3 class="txtcenter mcolor">- POS MANAGER -</h3>
  <p class="mcenter">
    <span>
    <!--[if (in_array('1', $access)) || (in_array('5', $access)) || (in_array('6', $access))]-->
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="track.php" title="POS Tracking">POS Track</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="fuel_calculator.php" title="Fuel calculator">Fuel Calculator</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="fuelbill.php" title="Fuel Bill">Fuel Bill</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	<!--[if (in_array('60', $access)) || (in_array('61', $access)) || (in_array('5', $access)) || (in_array('6', $access))]-->
	  <a href="outpost.php" title="Outpost Tracking">Outposts</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->  

	<!--[if (in_array('42', $access)) || (in_array('43', $access)) || (in_array('44', $access)) || (in_array('5', $access)) || (in_array('6', $access))]-->
      <a href="production.php" title="Production">Production</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->  
      
    <!--[if (in_array('40', $access)) || (in_array('41', $access)) || (in_array('45', $access)) || (in_array('5', $access)) || (in_array('6', $access))]-->
	  <a href="jobs.php" title="Jobs">Jobs</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->
	<!--[if (in_array('5', $access) || in_array('6', $access))]-->
	<a href="admin.php" title="Admin Panel">Admin Panel</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
	<!--[/if]-->
	  <a href="user.php" title="User Panel">User Panel</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="logout.php" title="Logout">Logout</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="about.php" title="About">About</a>
      &nbsp; &nbsp; |

    <!--[else]-->| &nbsp; &nbsp;
      <a href="login.php" title="Login">Login</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="register.php" title="Register">Register</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="about.php" title="About">About</a>
      &nbsp; &nbsp; |
    <!--[/if]-->
      <br /><br />
    </span>
  </p>
  <!--[getstatusmsg]-->
  <hr />
