<!--[* $Id: install_header.tpl 148 2008-08-08 14:57:14Z eveoneway $ *]-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-en">
<!--$Id: install_header.tpl 148 2008-08-08 14:57:14Z eveoneway $-->
<!--Pos-Tracker 3.0-->
<!--Visit http://pos-tracker.eve-corporate.net for  more information-->
<head>
  <title>POS Management</title>
  <link href="themes/<!--[$config.theme]-->/style/pos.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <script type="text/javascript" src="themes/<!--[$config.theme]-->/install/install.js"></script>
</head>
<body>
  <h3 class="txtcenter" style="color:#aaaaaa;">- POS MANAGER -</h3>
  <p class="mcenter">
    <span style="color:#aaaaaa;">
    <!--[if $access]-->
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="track.php" title="Tracking">Track</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="fuel_calculator.php" title="Fuel calculator">Fuel calculator</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="fuelbill.php" title="Fuel Bill">Fuel Bill</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="production.php" title="Production">Production</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="user.php" title="User Panel">User Panel</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="admin.php" title="Admin Panel">Admin Panel</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="logout.php" title="Logout">Logout</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="about.php" title="About">About</a>
      &nbsp; &nbsp; &nbsp; |
    <!--[else]-->| &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="index.php" title="Home">Home</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="login.php" title="Login">Login</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="register.php" title="Register">Register</a>
      &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; &nbsp;
      <a style="color:#aaaaaa;" href="about.php" title="About">About</a>
      &nbsp; &nbsp; &nbsp; |
    <!--[/if]-->
      <br /><br />
    </span>
  </p>
  <!--[getstatusmsg]-->
  <hr />
