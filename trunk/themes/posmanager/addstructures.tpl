<!--[* $Id: addstructures.tpl 131 2008-07-21 06:18:41Z stephenmg $ *]-->
<!--[include file='header.tpl']-->


  <form method="post" action="addstructure.php">
  <div>
    <input name="pos_id" value="<!--[$pos_id]-->" type="hidden" />
    <input name="amount" value="1" type="hidden" />
    <table>
    <!--[foreach item='structure' from=$structs]-->
      <tr>
        <td><!--[$structure.name]--></td>
        <td><input type="text" size="5" name="s_id<!--[$structure.id]-->" value="0" /></td>
      </tr>
    <!--[/foreach]-->
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td><input type="submit" name="action" value="Done" /></td>
      </tr>
    </table>
  </div>
  </form>


<!--[include file='footer.tpl']-->