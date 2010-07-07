<!--[* $Id: login.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->

  <div>
    <span class="arialwhite14 txtleft">If you are using the in-game browser, you must <strong>click</strong> the "Login" button!<br /><br /></span>
  </div>
  <!--[if $IS_IGB]-->
    <form method="post" action="login.php">
    <input type="hidden" name="name" value="<!--[$userinfo.username]-->" />
    <table>
      <tr>
        <td>Character Name:</td>
        <td><!--[$userinfo.username]--></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="pass" maxlength="255" />
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="action" value="Login" /></td>
      </tr>
    </table>
  <!--[else]-->
    <form method="post" action="login.php">
    <table class="mcenter">
      <tr>
        <td>Character Name:</td>
        <td><input type="text" name="name" maxlength="255" /></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="pass" maxlength="255" /></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="action" value="Login" /></td>
      </tr>
    </table>
    </form>
  <!--[/if]-->

<!--[include file='footer.tpl']-->
