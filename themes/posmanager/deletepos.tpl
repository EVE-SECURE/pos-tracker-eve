<!--[include file='header.tpl']-->
  <div class="mcenter">
    Are you sure you want to delete <!--[$pos_size_name]--> <!--[$pos_type_name]--> in <!--[$moonName]--><br /><br />
    <form method="post" action="deletepos.php">
    <div>
      <input type="hidden" name="i"      value="<!--[$pos_id]-->" />
      <input type="hidden" name="action" value="deletepos" />
      <input class="mButton" type="submit" value="Confirm Delete" />
    </div>
    </form>
    <br /><br />
    <a href="track.php" title="Back to tracking">Back to Tracking</a>
  </div>

<!--[include file='footer.tpl']-->
