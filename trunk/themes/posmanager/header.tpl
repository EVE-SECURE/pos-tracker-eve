<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en">
<head>
  <title>POS-Tracker 5.0.3 - FG Version</title>
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
    <!--[if $access]-->
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="track.php" title="POS Tracking">POS Track</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="fuel_calculator.php" title="Fuel calculator">Fuel calculator</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[if $access >= 2 ]-->
      <a href="fuelbill.php" title="Fuel Bill">Fuel Bill</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="production.php" title="Production">Production</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->
    <!--[if $access >= 3 ]-->
    <a href="outpost.php" title="Outpost Tracking">Outpost Track</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->
      <a href="user.php" title="User Panel">User Panel</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[if $access >= 4 ]-->
      <a href="admin.php" title="Admin Panel">Admin Panel</a>
      &nbsp; &nbsp; | &nbsp; &nbsp;
    <!--[/if]-->
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
      &nbsp; &nbsp; | &nbsp; &nbsp;
      <a href="about.php" title="Help">Help</a>
      &nbsp; &nbsp; |
    <!--[/if]-->
      <br /><br />
    </span>
  </p>
  <!--[getstatusmsg]-->
  <hr />
