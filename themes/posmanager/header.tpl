<!--[* $Id: header.tpl 305 2010-01-12 00:27:16Z stephenmg12 $ *]-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en">
<!--$Id: header.tpl 305 2010-01-12 00:27:16Z stephenmg12 $-->
<!--Pos-Tracker 3.0-->
<!--Visit http://pos-tracker.eve-corporate.net for  more information-->
<head>
  <title>POS-Tracker 3.0.0.305 RC 5 - FG Version</title>
  <link href="themes/<!--[$config.theme]-->/style/pos.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <!--[additional_header]-->
</head>
<body>
  <h3 class="txtcenter" style="color:#1B3169;">- POS MANAGER -</h3>
  <p class="mcenter">
    <span style="color:#1B3169;">
    <!--[if $access]-->
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="track.php" title="POS Tracking">POS Track</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="fuel_calculator.php" title="Fuel calculator">Fuel calculator</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
    <!--[if $access >= 2 ]-->
      <a style="color:#1B3169;" href="fuelbill.php" title="Fuel Bill">Fuel Bill</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="production.php" title="Production">Production</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
    <!--[/if]-->
    <!--[if $access >= 3 ]-->
    <a style="color:#1B3169;" href="outpost.php" title="Outpost Tracking">Outpost Track</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
    <!--[/if]-->
      <a style="color:#1B3169;" href="user.php" title="User Panel">User Panel</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
    <!--[if $access >= 4 ]-->
      <a style="color:#1B3169;" href="admin.php" title="Admin Panel">Admin Panel</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
    <!--[/if]-->
      <a style="color:#1B3169;" href="logout.php" title="Logout">Logout</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="about.php" title="About">About</a>
      &nbsp; &nbsp; &nbsp; |
    <!--[else]-->| &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="login.php" title="Login">Login</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="register.php" title="Register">Register</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="about.php" title="About">About</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#1B3169;" href="http://pos-tracker.eve-corporate.net/HomePage" title="Help">Help</a>
      &nbsp; &nbsp; &nbsp; |
    <!--[/if]-->
      <br /><br />
    </span>
  </p>
  <!--[getstatusmsg]-->
  <hr />
